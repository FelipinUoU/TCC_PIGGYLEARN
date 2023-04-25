<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
class CourseController extends Controller
{
    public function index() {
    
    $courses = Course::all();
    
    return view('index', ['courses' => $courses]);
    }

    public function create(){
        return view('courses.create');
    }

    public function edit($id){
        $course= Course::findOrFail($id);
        return view('courses.create', [ 'id' => $id, 'course' => $course]);
    }

    public function store(Request $request) {
        $course= new Course;

        $course->course_title = $request->title;
        $course->course_description = $request->description;
        $user = auth()->user();
        $course->user_id = $user->id;

        $course->save();

        if ($request->has('concluir')) {
            return redirect()->route('cursos.index')->with('msg', 'Curso criado com sucesso!');
        } elseif ($request->has('adicionar_aula')) {

            return view('aulas.create', compact('curso', 'aula'));
        }
    }

    public function update(Request $request, $id)
{
    $curso = Curso::findOrFail($id);

    // verifica se o formulário está sendo utilizado para edição
    $isEdit = $request->input('is_edit') === 'true';

    // se for edição, atualiza os dados do curso
    if ($isEdit) {
        $course->fill([
            
        ]);
        $course->save();

        // redireciona para a página de listagem de cursos
        return redirect()->route('cursos.index');
    } else {
        // se for criação, cria um novo curso
        $course = new Course([
            // campos do curso
        ]);
        $course->save();

        // redireciona para a página de criação de aula, passando o id do curso
        return redirect()->route('lessons.create', $course->id);
    }
}

    public function show($id) {

        $course = Course::findOrFail($id);

        $user = auth()->user();
      
        return view('courses.show', ['course' => $course]);
        
    }


        public function dashboard() {

            $user = auth()->user();

            $courses = $user->courses;


            return view('courses.dashboard', 
                ['courses' => $courses]
            );

        }
    }