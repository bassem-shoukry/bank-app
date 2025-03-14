<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;

class ConfirmDelete extends ModalComponent
{
    public $id;
    public $name;

    public function mount($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function delete()
    {
        // Dispatch the delete event to be handled by the parent component
        $this->dispatch('deleteDataset', id: $this->id);

        // Close the modal
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.modals.confirm-delete');
    }
}
