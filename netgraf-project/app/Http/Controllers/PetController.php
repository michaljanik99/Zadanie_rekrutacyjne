<?php

namespace App\Http\Controllers;

use App\Repositories\PetRepository;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PetController extends Controller
{
    private PetRepository $petRepository;
    private array $statuses = ['available', 'pending', 'sold'];

    public function __construct(PetRepository $petRepository)
    {
        $this->petRepository = $petRepository;
    }

    public function getStatuses(): array
    {
        return $this->statuses;
    }

    public function index(Request $request): View|RedirectResponse
    {
        try {
            $status = $request->query('status', 'available');
            $statuses = $this->getStatuses();
            $pets = $this->petRepository->findByStatus($status);
            return view('pets.index', compact('pets','statuses'));
        } catch (RequestException $e) {
            return back()->withErrors(['msg' => 'Error fetching pets' . $e->getMessage()]);
        }
    }

    public function create(): View
    {
        $statuses = $this->getStatuses();
        return view('pets.create',  compact('statuses'));
    }

    public function store(Request $request): View|RedirectResponse
    {
        try {
            $this->petRepository->add($request->all());
            $status = $request->input('status', 'available');
            return redirect()->route('pets.index', ['status' => $status]);
        } catch (RequestException $e) {
            return back()->withErrors(['msg' => 'Error adding pet' . $e->getMessage()]);
        }
    }

    public function edit($id): View|RedirectResponse
    {
        try {
            $pet = $this->petRepository->findById($id);
            $statuses = $this->getStatuses();
            return view('pets.edit',  compact('statuses', 'pet'));
        } catch (RequestException $e) {
            return back()->withErrors(['msg' => 'Error fetching pet data' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id): View|RedirectResponse
    {
        try {
            $this->petRepository->update($id, $request->all());
            $status = $request->input('status', 'available');
            return redirect()->route('pets.index', ['status' => $status]);
        } catch (RequestException $e) {
            return back()->withErrors(['msg' => 'Error updating pet'. $e->getMessage()]);
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $this->petRepository->delete($id);
            return back();
        } catch (RequestException $e) {
            return back()->withErrors(['msg' => 'Error deleting pet' . $e->getMessage()]);
        }
    }
}
