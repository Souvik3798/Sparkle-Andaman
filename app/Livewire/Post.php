<?php

namespace App\Livewire;

use App\Models\Posts;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Post extends Component
{
    #[Rule('required|min:2')]
    public $name = '';

    #[Rule('required|email')]
    public $email = '';

    #[Rule('required|min:10')]
    public $comment = '';


    public function create(){

        $this->validate();

        Posts::create([
            'name'=>$this->name,
            'email'=>$this->email,
            'comment'=>$this->comment
        ]);

        $this->reset('name','email','comment');
        request()->session()->flash('success','Review Posted Successfully');
    }

    public function render()
    {
        $posts = Posts::all()->sortByDesc('created_at');
        return view('livewire.post',['posts'=>$posts]);
    }

}
