<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {

        return [
            'category_id' => $this->faker->numberBetween(1, 5),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->numberBetween(1, 3),
            'email' => $this->faker->unique()->safeEmail(),
            'tel' => $this->faker->numerify('###########'),
            'address' => $this->faker->address(),
            'building' => $this->faker->secondaryAddress(),
            'detail' => $this->faker->randomElement([
                '注文内容の変更方法について教えてください。',
                '商品の使い方について確認したいです。',
                '配送状況を確認したいのですが、どこで確認できますか。',
                '会員登録の手順を教えていただけますか。',
                '返品や交換の方法について知りたいです。',
            ]),
        ];
    }
}
