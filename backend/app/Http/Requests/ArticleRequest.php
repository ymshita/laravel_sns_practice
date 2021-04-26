<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:50',
            'body' => 'required|max:500',
            'tags' => 'json|regex:/^(?!.*\s).+$/u|regex:/^(?!.*\/).*$/u',
        ];
    }

    /**
     * エラーメッセージの項目名のカスタマイズ
     */
    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'body' => '本文',
            'tag' => 'タグ'
        ];
    }

    /**
     * バリデーション後に自動で呼ばれるメソッド
     */
    public function passedValidation()
    {
        // タグJsonを連想配列に変換
        $this->tags = collect(json_decode($this->tags))
            ->slice(0, 5) // タグは5この制限
            ->map(function ($requestTag) {
                return $requestTag->text;
            });
    }
}
