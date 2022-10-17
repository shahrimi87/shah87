<?php

namespace App\Http\Livewire;
use App\Models\Student;

use Livewire\Component;

class Crud extends Component
{

    public $students,$name,$email,$mobile,$student_id;
    public $isModalOpen = 0;
    public function render()
    {
        $this->students=Student::all();
        return view('livewire.crud');
    }
    public function create(){

        $this->resetCreateForm();
        $this->openModalPopover();
    }
    public function openModalPopover(){

        $this->isModelOpen=true;   
    }
    public function closeModalPopover(){

        $this->isModelOpen=false;
    }
    private function resetCreateForm(){

        $this->name='';
        $this->email='';
        $this->mobile='';
    }

    public function store(){
        $this->validate([
         'name' => 'required',
         'email' => 'required',
         'mobile' => 'required',
        ]);
        
        Student::updateorCreate(['id'=>$this->student_id],[

            'name'=>$this->name,
            'email'=>$this->email,
            'mobile'=>$this->mobile,
        ]);

        session()->flash('message',$this->student_id?'Student Updated.':'Student Created.');
        $this->CloseModelPopover();
        $this->resetCreateForm();

    }
    
    public function edit($id){

       $student = Student::findOrFail($id);
       $this->student_id = $id;
       $this->name = $student->name;
       $this->email= $student->email;
       $this->mobile= $student->mobile;

       $this->openModalPopover();

    }


    public function delete($id) {

       Student::find($id)->delete();
       Session()->flash ('message','student deleted.');

    }



}
