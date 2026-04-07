<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        $keyword = trim((string) $request->input('keyword', ''));
        $gender = $request->input('gender');
        $categoryId = $request->input('category_id');
        $contactDate = $request->input('contact_date');

        $contacts = Contact::query()
            ->with('category')
            ->when($keyword !== '', function ($query) use ($keyword) {
                $likeKeyword = '%' . $keyword . '%';

                $query->where(function ($innerQuery) use ($likeKeyword) {
                    $innerQuery->where('email', 'like', $likeKeyword)
                        ->orWhere('last_name', 'like', $likeKeyword)
                        ->orWhere('first_name', 'like', $likeKeyword)
                        ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", [$likeKeyword])
                        ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", [$likeKeyword]);
                });
            })
            ->when($gender !== null && $gender !== '', function ($query) use ($gender) {
                $query->where('gender', (int) $gender);
            })
            ->when($categoryId !== null && $categoryId !== '', function ($query) use ($categoryId) {
                $query->where('category_id', (int) $categoryId);
            })
            ->when($contactDate !== null && $contactDate !== '', function ($query) use ($contactDate) {
                $query->whereDate('created_at', $contactDate);
            })
            ->orderByDesc('created_at')
            ->paginate(7)
            ->withQueryString();

        return view('admin.index', [
            'contacts' => $contacts,
            'categories' => Category::query()->orderBy('id')->get(),
            'genders' => [
                1 => '男性',
                2 => '女性',
                3 => 'その他',
            ],
            'filters' => [
                'keyword' => $keyword,
                'gender' => $gender,
                'category_id' => $categoryId,
                'contact_date' => $contactDate,
            ],
        ]);
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return back();
    }
}
