<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $this->filters($request);

        $contacts = $this->buildContactQuery($filters)
            ->orderByDesc('created_at')
            ->paginate(7)
            ->withQueryString();

        return view('admin.index', [
            'contacts' => $contacts,
            'categories' => Category::query()->orderBy('id')->get(),
            'genders' => $this->genders(),
            'filters' => $filters,
        ]);
    }

    public function search(Request $request): View
    {
        return $this->index($request);
    }

    public function reset(): RedirectResponse
    {
        return redirect()->route('admin.index');
    }

    public function export(Request $request): StreamedResponse
    {
        $filters = $this->filters($request);
        $contacts = $this->buildContactQuery($filters)
            ->orderByDesc('created_at')
            ->get();

        $fileName = 'contacts_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($contacts) {
            $stream = fopen('php://output', 'w');

            if ($stream === false) {
                return;
            }

            fwrite($stream, "\xEF\xBB\xBF");

            fputcsv($stream, ['お名前', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせの種類', 'お問い合わせ内容', '作成日']);

            foreach ($contacts as $contact) {
                fputcsv($stream, [
                    trim($contact->last_name . ' ' . $contact->first_name),
                    $this->genders()[$contact->gender] ?? '',
                    $contact->email,
                    $contact->tel,
                    $contact->address,
                    $contact->building,
                    $contact->category->content ?? '',
                    $contact->detail,
                    optional($contact->created_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($stream);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function buildContactQuery(array $filters): Builder
    {
        return Contact::query()
            ->with('category')
            ->when($filters['keyword'] !== '', function ($query) use ($filters) {
                $likeKeyword = '%' . $filters['keyword'] . '%';

                $query->where(function ($innerQuery) use ($likeKeyword) {
                    $innerQuery->where('email', 'like', $likeKeyword)
                        ->orWhere('last_name', 'like', $likeKeyword)
                        ->orWhere('first_name', 'like', $likeKeyword)
                        ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", [$likeKeyword])
                        ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", [$likeKeyword]);
                });
            })
            ->when($filters['gender'] !== null && $filters['gender'] !== '', function ($query) use ($filters) {
                $query->where('gender', (int) $filters['gender']);
            })
            ->when($filters['category_id'] !== null && $filters['category_id'] !== '', function ($query) use ($filters) {
                $query->where('category_id', (int) $filters['category_id']);
            })
            ->when($filters['contact_date'] !== null && $filters['contact_date'] !== '', function ($query) use ($filters) {
                $query->whereDate('created_at', $filters['contact_date']);
            });
    }

    private function filters(Request $request): array
    {
        return [
            'keyword' => trim((string) $request->input('keyword', '')),
            'gender' => $request->input('gender'),
            'category_id' => $request->input('category_id'),
            'contact_date' => $request->input('contact_date'),
        ];
    }

    private function genders(): array
    {
        return [
            1 => '男性',
            2 => '女性',
            3 => 'その他',
        ];
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return back();
    }
}
