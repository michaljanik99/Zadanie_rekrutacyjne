<?php

namespace App\Http\Controllers;

use App\Repositories\PetRepository;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class PetController extends Controller
{
    private $petRepository;

    public function __construct(PetRepository $petRepository)
    {
        $this->petRepository = $petRepository;
    }

    public function index(Request $request)
    {
        try {
            $status = $request->query('status', 'available');
            $pets = $this->petRepository->findByStatus($status);
            return view('pets.index', compact('pets'));
        } catch (RequestException $e) {
            return back()->withErrors(['msg' => 'Error fetching pets']);
        }
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        try {
            $this->petRepository->add($request->all());
            $status = $request->input('status', 'available');
            return redirect()->route('pets.index', ['status' => $status]);
        } catch (RequestException $e) {
            \Log::error('Error adding pet: ', ['message' => $e->getMessage()]);
            return back()->withErrors(['msg' => 'Error adding pet']);
        }
    }

    public function edit($id)
    {
        try {
            $pet = $this->petRepository->findById($id);
            return view('pets.edit', compact('pet'));
        } catch (RequestException $e) {
            return back()->withErrors(['msg' => 'Error fetching pet data']);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->petRepository->update($id, $request->all());
            $status = $request->input('status', 'available');
            return redirect()->route('pets.index', ['status' => $status]);
        } catch (RequestException $e) {
            \Log::error('Error updating pet: ', ['message' => $e->getMessage()]);
            return back()->withErrors(['msg' => 'Error updating pet']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->petRepository->delete($id);
            return back();
        } catch (RequestException $e) {
            return back()->withErrors(['msg' => 'Error deleting pet']);
        }
    }
}
