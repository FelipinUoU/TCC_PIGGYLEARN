<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
class LessonController extends Controller
{
    public function create($id){

        $course = Course::findOrFail($id);
        return view('courses.lessons.create',['course'=> $course]);
    }
    public function edit($id, $lesson_id){

        $course = Course::findOrFail($id);
        $lesson = Lesson::findOrFail($lesson_id);

        return view('courses.lessons.create',['course'=> $course, 'lesson' => $lesson]);
    }
    public function store(Request $request)
    {
        // Validar dados do formulário de criação de aulas
        $data = request()->validate([
            'title' => 'required',
            'content' => 'required',
            // Adicione outras validações necessárias
        ]);
        $id = $request->id;
        // Criar primeira aula relacionada ao curso
        $lastSeq = Lesson::where('course_id', $id)->orderByDesc('seq')->first()?->seq ?? 0;
        $lesson = new Lesson;
        $lesson->title = $request->title;
        $lesson->content = $request->content;
        $lesson->course_id = $request->course_id;
        $lesson->hasTest = $request->filled('hasTest') ? $request->hasTest : false;
        $lesson->seq = $lastSeq + 1;
        $lesson->save();
        
        
        if ($lesson->hasTest != true){
        // Redirecionar para a view de detalhes do curso, por exemplo
        return redirect()->route('courses.edit', ['id' => $request->course_id]);
        } else {
          return view('courses.lessons.tests.create', ['id' => $lesson->course_id, 'lesson' => $lesson->id]);
            }
       
        //return($course->lessons()->toArray()); 
    }
    public function update(Request $request) {
        $data=$request->all();
        $lesson = Lesson::findOrFail($request->id);
        $hasTestOld = $lesson->hasTest;
        $hasTestNow = $request->input('hasTest');
        $lesson->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'hasTest' => $request->filled('hasTest') ? $request->hasTest : false,
            ]);
            // Verificar a condição para redirecionamento
        if ($hasTestOld && !$hasTestNow) {
        // Caso o campo hasTest estivesse marcado anteriormente e foi desmarcado agora
        // Redirecionar para a rota courses.edit, passando o ID do curso relacionado à aula
                return redirect()->route('courses.edit', ['id' => $lesson->course_id]);
        } elseif (!$hasTestOld && $hasTestNow) {
                // Caso o campo hasTest não estivesse marcado anteriormente e foi marcado agora
                // Redirecionar para a rota tests.create, passando o ID da lesson
                return redirect()->route('tests.create', ['id' => $lesson->course_id, 'lesson' => $lesson->id]);
        } else {
                // Caso contrário, apenas salvar as alterações e redirecionar para a rota desejada
                $lesson->save();
                return redirect()->route('courses.edit', ['id' => $lesson->course_id]);
        }
    }
    public function destroy($id)
{
    $lesson = Lesson::find($id);
    // Verificar se a lesson tem um teste relacionado
    if ($lesson->hasTest!=true) {
        // Se tiver um teste relacionado, atualizar o hasTest para false e excluir o teste
        $lesson->hasTest = false;
        //$lesson->test()->delete();
    }

    // Obter o curso relacionado à lesson
    $course = $lesson->course;

    // Obter as lessons do curso com sequência maior que a da lesson a ser excluída
    $lessonsToUpdate = $course->lessons()->where('seq', '>', $lesson->seq)->get();

    // Atualizar a sequência das lessons remanescentes
    foreach ($lessonsToUpdate as $lessonToUpdate) {
        $lessonToUpdate->seq -= 1;
        $lessonToUpdate->save();
    }

    // Excluir a lesson
    $lesson->delete();

    return redirect()->route('courses.edit', ['course' => $course->id]);
}
}