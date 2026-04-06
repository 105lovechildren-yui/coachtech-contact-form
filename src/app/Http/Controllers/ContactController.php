<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create', [
            'categories' => $this->categories(),
        ]);
    }

    public function confirm(Request $request)
    {
        $categories = $this->categories();
        $selectedCategory = $categories->firstWhere('id', (int) $request->input('category_id'));
        $tel = (array) $request->input('tel', []);

        return view('contact.confirm', [
            'contact' => [
                'last_name' => $request->input('last_name', ''),
                'first_name' => $request->input('first_name', ''),
                'full_name' => trim($request->input('last_name', '') . ' ' . $request->input('first_name', '')),
                'gender' => $request->input('gender', ''),
                'gender_label' => $this->genderLabel($request->input('gender', '')),
                'email' => $request->input('email', ''),
                'tel' => $tel,
                'tel_display' => implode('', array_filter($tel, fn($value) => $value !== null && $value !== '')),
                'address' => $request->input('address', ''),
                'building' => $request->input('building', ''),
                'category_id' => $request->input('category_id', ''),
                'category_content' => $selectedCategory->content ?? '',
                'detail' => $request->input('detail', ''),
            ],
        ]);
    }

    public function thanks()
    {
        return view('contact.thanks');
    }

    private function categories()
    {
        return collect([
            (object) ['id' => 1, 'content' => '商品のお届けについて'],
            (object) ['id' => 2, 'content' => '商品の交換について'],
            (object) ['id' => 3, 'content' => '商品トラブル'],
            (object) ['id' => 4, 'content' => 'ショップへのお問い合わせ'],
            (object) ['id' => 5, 'content' => 'その他'],
        ]);
    }

    private function genderLabel(string $gender): string
    {
        $labels = [
            '1' => '男性',
            '2' => '女性',
            '3' => 'その他',
        ];

        return $labels[$gender] ?? '';
    }

    public function store(Request $request)
    {
        $contactData = [
            'last_name' => $request->input('last_name', ''),
            'first_name' => $request->input('first_name', ''),
            'gender' => $request->input('gender', ''),
            'email' => $request->input('email', ''),
            'tel' => implode('', array_filter((array) $request->input('tel', []), fn($value) => $value !== null && $value !== '')),
            'address' => $request->input('address', ''),
            'building' => $request->input('building', ''),
            'category_id' => $request->input('category_id', ''),
            'detail' => $request->input('detail', ''),
        ];

        // TODO: Contactモデル実装後に、保存処理を追加する
        // TODO: Contact::create() には $request->all() ではなく、上で明示した保存項目だけを渡す
        // TODO: 電話番号は配列のままではなく、$contactData['tel'] のように文字列へ整形してから保存する
        // TODO: category_id などは、実際のテーブルカラム構成に合わせてキー名・保存値を調整する
        // Contact::create($contactData);

        return redirect()->route('contact.thanks');
    }
}
