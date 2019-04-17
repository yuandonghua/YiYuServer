<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArtRequest extends FormRequest
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
            'title' => 'required|string',
            'pulisher_user_id' => 'required|integer',
            'classify_id' => 'required|integer',
            'user_classify_id' => 'required|integer',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'long' => 'required|integer',
            'shape' => 'required|integer',
            'main_image' => 'required|string',
            'art_info_model' => 'required|array',
            'art_info_model.id' => 'required|integer',
            'art_info_model.author' => 'required|string',
            'art_info_model.image_info' => 'required|string',
            'create_year' => 'required|string',
            'art_info_model.introduce' => 'required|string'
        ];
    }

    /**
     * 获取已定义的验证规则的错误消息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => '名称不允许为空',
            'pulisher_user_id.required' => '发布人ID不允许为空',
            'classify_id.required' => '分类ID不允许为空',
            'user_classify_id.required' => '用户分类ID不允许为空',
            'width.required' => '宽度不允许为空',
            'height.required' => '高度不允许为空',
            'long.required' => '长度不允许为空',
            'shape.required' => '类型不允许为空',
            'main_image.required' => '主图地址不允许为空',
            'title.string' => '标题必须是字符串',
            'pulisher_user_id.integer' => '发布人必须为整数',
            'classify_id.integer' => '分类必须为整数',
            'user_classify_id.integer' => '用户分类必须为整数',
            'width.integer' => '宽度必须为整数',
            'height.integer' => '高度必须为整数',
            'long.integer' => '长度必须为整数',
            'shape.integer' => '类型必须为整数',
            'main_image.string' => '必须为字符串',
            'art_info_model.required' => '作品信息不允许为空',
            'art_info_model.array' => '作品信息必须是数组',
            'art_info_model.id.required' => '作品详细信息主键不允许为空',
            'art_info_model.id.integer' => '作品详细信息主键必须是主键',
            'art_info_model.author.required' => '作者不允许为空',
            'art_info_model.author.string' => '作者必须是字符串',
            'art_info_model.image_info.required' => '图片不允许为空',
            'art_info_model.image_info.string' => '图片必须是字符串',
            'create_year.required' => '创建年份不允许为空',
            'create_year.string' => '创建年份必须是字符串',
            'art_info_model.introduce.required' => '作品介绍不允许为空',
            'art_info_model.introduce.string' => '作品介绍必须是字符串',
        ];
    }
}
