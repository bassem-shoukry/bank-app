<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $message = '';
    public $success = false;

    protected $rules = [
        'name' => 'required|min:2|max:100',
        'email' => 'required|email|max:100',
        'message' => 'required|min:10|max:1000',
    ];

    public function submit()
    {
        $this->validate();

        // Store the contact message in the database
        $contactMessage = ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ]);

        // Optional: Send an email notification
        // Mail::to(config('mail.admin_address'))->send(new ContactFormSubmitted($contactMessage));

        // Reset form and show success message
        $this->reset(['name', 'email', 'message']);
        $this->success = true;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
