<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute deve ser aceito.',
    'active_url' => ':attribute não é uma URL válida.',
    'after' => ':attribute deve ser uma data depois de :date.',
    'after_or_equal' => ':attribute deve ser uma data depois ou igual a :date.',
    'alpha' => ':attribute deve apenas conter letras.',
    'alpha_dash' => ':attribute deve apenas conter letras, numeros, traços e sublinhados.',
    'alpha_num' => ':attribute deve apenas conter letras e numeros.',
    'array' => ':attribute deve ser um array.',
    'before' => ':attribute deve ser uma data antes de :date.',
    'before_or_equal' => ':attribute deve ser uma data antes ou igual a :date.',
    'between' => [
        'numeric' => ':attribute deve estar entre :min e :max.',
        'file' => ':attribute deve estar entre :min e :max kilobytes.',
        'string' => ':attribute deve estar entre :min e :max caracteres.',
        'array' => ':attribute deve ter entre :min e :max items.',
    ],
    'boolean' => ':attribute deve ser verdadeiro ou falso.',
    'confirmed' => ':attribute de confirmação não combina.',
    'date' => ':attribute não é uma data válida.',
    'date_equals' => ':attribute deve ser uma data igual a :date.',
    'date_format' => ':attribute não combina com o formato :format.',
    'different' => ':attribute e :other devem ser diferentes.',
    'digits' => ':attribute deve ter :digits digitos.',
    'digits_between' => ':attribute deve estar entre :min e :max digitos.',
    'dimensions' => ':attribute tem dimensões inválidas para a imagem.',
    'distinct' => ':attribute tem valor duplicado.',
    'email' => ':attribute deve ser uma email válido.',
    'ends_with' => ':attribute deve terminar com um dos seguintes valores: :values.',
    'exists' => ':attribute selecionado é inválido.',
    'file' => ':attribute deve ser um arquivo.',
    'filled' => ':attribute deve ser preenchido.',
    'gt' => [
        'numeric' => ':attribute deve ser maior do que :value.',
        'file' => ':attribute deve ser maior do que :value kilobytes.',
        'string' => ':attribute deve ser maior do que :value caracteres.',
        'array' => ':attribute deve ter mais do que :value items.',
    ],
    'gte' => [
        'numeric' => ':attribute deve ser maior ou igual a :value.',
        'file' => ':attribute deve ser maior ou igual a :value kilobytes.',
        'string' => ':attribute deve ser maior ou igual a :value caracteres.',
        'array' => ':attribute deve ter :value items ou mais.',
    ],
    'image' => ':attribute deve ser uma imagem.',
    'in' => ':attribute é inválido.',
    'in_array' => ':attribute não existe em :other.',
    'integer' => ':attribute deve ser do tipo integer.',
    'ip' => ':attribute deve ser um endereço de IP válido.',
    'ipv4' => ':attribute deve ser um endereço de IPV4 válido.',
    'ipv6' => ':attribute deve ser um endereço de IPV6 válido.',
    'json' => ':attribute deve ser do tipo JSON.',
    'lt' => [
        'numeric' => ':attribute deve ser menos do que :value.',
        'file' => ':attribute deve ser menos do que :value kilobytes.',
        'string' => ':attribute deve ser menos do que :value caracteres.',
        'array' => ':attribute deve ter menos do que :value items.',
    ],
    'lte' => [
        'numeric' => ':attribute deve ser menos ou igual a :value.',
        'file' => ':attribute deve ser menos ou igual a :value kilobytes.',
        'string' => ':attribute deve ser menos ou igual a :value caracteres.',
        'array' => ':attribute não deve ter mais do que :value items.',
    ],
    'max' => [
        'numeric' => ':attribute não pode ter mais do que :max.',
        'file' => ':attribute não pode ter mais do que :max kilobytes.',
        'string' => ':attribute não pode ter mais do que :max caracteres.',
        'array' => ':attribute não pode ter mais do que :max items.',
    ],
    'mimes' => ':attribute deve ser um arquivo do tipo type: :values.',
    'mimetypes' => ':attribute deve ser um arquivo do tipo type: :values.',
    'min' => [
        'numeric' => ':attribute deve ter pelo menos :min.',
        'file' => ':attribute deve ter pelo menos :min kilobytes.',
        'string' => ':attribute deve ter pelo menos :min caracteres.',
        'array' => ':attribute deve ter pelo menos :min items.',
    ],
    'not_in' => ':attribute selecionado é inválido.',
    'not_regex' => ':attribute tem um formato inválido.',
    'numeric' => ':attribute deve ser um numero.',
    'password' => 'A senha esta incorreta.',
    'present' => ':attribute deve estar presente.',
    'regex' => ':attribute tem um formato inválido.',
    'required' => ':attribute é obrigatório.',
    'required_if' => ':attribute é obrigatório quando :other é :value.',
    'required_unless' => ':attribute é obrigatório a não ser que :other tem em :values.',
    'required_with' => ':attribute é obrigatório quando conter :values.',
    'required_with_all' => ':attribute é obrigatório quando conter :values.',
    'required_without' => ':attribute é obrigatório quando não existir :values.',
    'required_without_all' => ':attribute é obrigatório quando não existir nenhum destes valores :values.',
    'same' => ':attribute e :other devem combinar.',
    'size' => [
        'numeric' => ':attribute deve ter :size.',
        'file' => ':attribute deve ter :size kilobytes.',
        'string' => ':attribute deve ter :size caracteres.',
        'array' => ':attribute deve conter :size items.',
    ],
    'starts_with' => ':attribute deve começar com um dos seguintes valores :values.',
    'string' => ':attribute deve ser uma string.',
    'timezone' => ':attribute deve ter uma zona de hora válida.',
    'unique' => ':attribute já existe.',
    'uploaded' => ':attribute falhou no upload.',
    'url' => ':attribute tem formato inválido.',
    'uuid' => ':attribute deve ter UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'Nome',
        'mobile' => 'Numero de Celular',
        'address' => 'Endereço',
        'district' => 'Bairro',
        'city' => 'Cidade',
        'state' => 'Estado',
        'password' => 'Senha',
        'slug' => 'URL',
        'number' => 'Numero',
        'opening_hours_start' => 'Inicio do Funcionamento',
        'opening_hours_end' => 'Fim do Funcionamento',
        'delivery_time' => 'Tempo de Entrega',
        'value_min' => 'Valor Minimo',
        'tax' => 'Taxa de Entrega',
        'payment_way_id' => 'Forma de Pagamento',
        'phone' => 'Numero de Telefone',
        'whatsapp' => 'Numero para WhatsApp',
        'logo_path' => 'Caminho do Logo',
        'insc_est' => 'Inscrição Estadual',
        'cnpj' => 'CNPJ',
        'info' => 'Informação',
        'about_us' => 'Sobre Nós',
        'description' => 'Descrição',
        'image' => 'Imagem',
        'image_path' => 'Caminho da Imagem',
        'restaurant_id' => 'Restaurante',
        'item_id' => 'Cardápio',
        'active' => 'Ativo',
        'price' => 'Preço',
        'start' => 'Inicio da Validade',
        'end' => 'Fim da Validade',
        'category_id' => 'Categoria',
        'type' => 'Tipo',
        'promotion_id' => 'Promoção',
        'role_id' => 'Cargo',
        'user_id' => 'Usuário',
        'code' => 'Código',
        'value' => 'Valor',
        'coupon_id' => 'Cupom',
        'coupon_code' => 'Código do Cupom',
        'coupon_value' => 'Valor do Cupom',
        'total_final' => 'Total Final',
        'total' => 'Total',
        'status' => 'Status',
        'order_id' => 'Venda',
        'restaurant' => 'Restaurante',
        'category' => 'Categoria',
        'amount' => 'Quantidade',
    ],

];
