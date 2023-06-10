@extends('layouts.main')

@section('title', 'PL - Adicionar Aula')
    
@section('content')

<!-- Criar Aulas --> 
<div class="container" id="lesson-form-container">
    <form method="POST" action="{{ isset($lesson) ? route('lessons.update',[$course->id, $lesson->id]) : route('lessons.store', $course->id) }}">
        @csrf
        
        @if(isset($lesson))
        <input type="hidden" name="id" value="{{$lesson->id}}"> 
        @method('PUT')
      @endif
        <input type="hidden" name="course_id" value="{{ $course->id }}">
        <div class="form-group">
            <label for="title" >Aula:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Título da Aula." @if(isset($lesson)) value="{{$lesson->title}}"@endif>
        </div>
        <div class="form-group">
            <label for="content" >Descrição:</label>
            <textarea name="content" id="content" class="form-control" placeholder="Qual o conteúdo desta aula?">@if (isset($lesson)){{$lesson->content}}@endif</textarea>
        </div>

                <div class="form-group">
                    <input type="checkbox" name="hasTest" value="1" {{ isset($lesson) && $lesson->hasTest ? 'checked disabled' : '' }}> Tem avaliação?
                </div>
                <div class="col-md-10 offset-md-1 dashboard-events-container">
                    @if (isset($lesson))        
                    @if($lesson->hastest == true)

                <table class="table"> 

                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col"></th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                            <tr>
                                <td><a href="#">{{ $test['title'] }}</a></td>
                                <td>0</td>
                                <td>
                                    <a href="{{ route('tests.edit', ['lesson' => $lesson->id, 'lesson' => $lesson['id']]) }}" class="btn btn-info edit-btn">Editar</a> 
                                    <form action="{{ route('lessons.destroy', ['course' => $course->id, 'id' => $lesson['id']]) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-btn">Deletar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                            <tr>
                                <td scropt="row"></td>
                                <td colspan="4">
                                <a href="/courses/{{$course->id}}/lessons/create" id="botaoAdicionarAula"  class="btn btn-custom">Adicionar Aula</a> 
                                </td>
                            </tr>    
                    </tbody>

                </table>

                @else
                    <div id="divcriaraula">
                        <p id="cortexto">Este curso ainda não possui aulas</p><a id="botaoCriarAulas" class="btn btn-custom" href="/courses/{{$course->id}}/lessons/create">Adicionar Aula</a>
                    </div>
                @endif

                @else
                    <input type="hidden" name="create_course_and_add_lesson" value="1">
                    <button id="botaoCriar" type="submit" class="btn btn-custom">Adicionar Aula</button>
                    <!-- Botão de criar aula -->
                @endif

            </div>
        <button type="submit">{{ isset($lesson) ? 'Atualizar Aula' : 'Criar Aula' }} </button>
    </form>
</div>

@endsection