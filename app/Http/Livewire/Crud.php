<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;

class Crud extends Component
{
    public $students, $nome, $email, $num_contato, $student_id;
    public $isModalOpen = 0;

    public function render()
    {
        $this->students = Student::all();
        return view('livewire.crud');
    }

    public function create(){
      $this->resetCreateForm();
      $this->openModalPopover();
    }

    public function openModalPopover(){
      $this->isModalOpen = true;
    }

    public function closeModalPopover(){
      $this->isModalOpen = false;
    }

    private function resetCreateForm(){
      $this->nome = '';
      $this->email = '';
      $this->num_contato = '';
    }

    public function store(){
      $this->validate([
        'nome' => 'required',
        'email' => 'required',
        'num_contato' => 'required'
      ]);

      Student::updateOrCreate(
        ['id' => $this->student_id],
        [
          'nome' => $this->nome,
          'email' => $this->email,
          'num_contato' => $this->contato
        ]
      );

      session()->flash('message', $this->student_id ? 'Student Updated.' : 'Student Created.');

      $this->closeModalPopover();
      $this->resetCreateForm();

    }

    public function edit($id){
      $student = Student::findOrFail($id);
      $this->student_id = $id;
      $this->nome = $student->nome;
      $this->email = $student->email;
      $this->num_contato = $student->contato;

      $this->openModalPopover();

    }

    public function delete($id){
      Student::find($id)->delete();
      session()->flash('message', 'Student delete.');
    }

}
