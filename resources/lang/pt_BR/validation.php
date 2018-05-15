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

    'accepted'             => 'Esse campo precisa ser aceito.',
    'active_url'           => 'A URL informada não é válida.',
    'after'                => 'A data deve ser posterior a :date.',
    'alpha'                => 'Esse campo só pode conter letras.',
    'alpha_dash'           => 'Esse campo só pode conter letras, números, e traços.',
    'alpha_num'            => 'Esse campo só pode conter letras and números.',
    'array'                => 'Esse campo deve ser uma lista.',
    'before'               => 'A data deve ser anterior a :date.',
    'between'              => [
        'numeric' => 'O valor deve estar entre :min e :max.',
        'file'    => 'O arquivo precisa ter entre :min e :max kB.',
        'string'  => ':attribute deve estar entre :min e :max caracteres.',
        'array'   => 'Sõa necessários entre :min e :max itens.',
    ],
    'boolean'              => 'A resposta deve ser sim ou não.',
    'confirmed'            => 'As senhas não são iguais.',
    'date'                 => 'Informe uma data válida.',
    'date_format'          => 'A data deve estar no formato :format.',
    'different'            => 'Os campos :attribute e :other não podem ser iguais.',
    'digits'               => 'Esse valor deve conter :digits dígitos.',
    'digits_between'       => 'Esse valor deve conter entre :min e :max dígitos.',
    'dimensions'           => 'Imagem de proporções inválidas.',
    'distinct'             => 'Não são permitidos valores duplicados.',
    'email'                => 'O email informado não é válido.',
    'exists'               => ':attribute não encontrado.',
    'file'                 => 'É necessário anexar um arquivo.',
    'filled'               => 'Campo obrigatório.',
    'image'                => 'É necessário enviar uma imagem.',
    'in'                   => 'Valor inválido.',
    'in_array'             => 'Esse valor deve estar presente em :other.',
    'integer'              => 'Somente valores inteiros são aceitos.',
    'ip'                   => 'Endereço de IP inválido.',
    'json'                 => 'JSON inválido.',
    'max'                  => [
        'numeric' => 'O valor máximo é :max.',
        'file'    => 'O tamanho máximo é de :max kB.',
        'string'  => 'Limite de :max caracteres excedido.',
        'array'   => 'Selecione no máximo :max itens.',
    ],
    'mimes'                => 'Somente os formatos :values são aceitos.',
    'mimetypes'            => 'Somente os formatos :values são aceitos.',
    'min'                  => [
        'numeric' => 'O valor mínimo é :min.',
        'file'    => 'O tamanho mínimo é de :min kB.',
        'string'  => 'Informe pelo menos :min caracteres.',
        'array'   => 'Selecione pelo menos :min items.',
    ],
    'not_in'               => 'Valor inválido.',
    'numeric'              => 'É necessário informar um número.',
    'present'              => 'Campo obrigatório.',
    'regex'                => 'Formato inválido.',
    'required'             => 'Campo obrigatório.',
    'required_if'          => 'Campo obrigatório se :other for :value.',
    'required_unless'      => 'Campo obrigatório, a menos que :other esteja entre :values.',
    'required_with'        => 'Como :values estão presentes, esse campo é obrigatório.',
    'required_with_all'    => 'Como :values estão presentes, esse campo é obrigatório.',
    'required_without'     => 'Como :values não estão presentes, esse campo é obrigatório.',
    'required_without_all' => 'Campo obrigatório quando os campos :values estão presentes.',
    'same'                 => 'Valor difere do campo :other.',
    'size'                 => [
        'numeric' => 'O tamanho deve ser :size.',
        'file'    => 'O tamanho deve ser :size kB.',
        'string'  => 'São necessários :size caracteres.',
        'array'   => 'Selecione :size itens.',
    ],
    'string'                     => 'Informe uma frase.',
    'timezone'                   => 'Informe uma zona válida.',
    'unique'                     => ':attribute já cadastrado.',
    'clean_unique'               => ':attribute já cadastrado.',
    'uploaded'                   => 'Falha ao receber arquivo.',
    'url'                        => 'URL inválida.',

    /*
    |--------------------------------------------------------------------------
    | Custom Rules
    |--------------------------------------------------------------------------
    | Custom Local Rules.
    */
    'valid_date_format' => 'Informe uma data válida.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'password' => 'Senha',

        // bank accounts
        'account_branch' => 'Agência',
        'account_number' => 'Número da Conta',
        'bank_id'        => 'Banco',
        'description'    => 'Descrição',

        'name'             => 'Nome',
        'address.street'   => 'Rua',
        'address.number'   => 'Número',
        'address.district' => 'Bairro',
        'address.city'     => 'Cidade',
        'address.zip'      => 'CEP',
        'nature'           => 'Natureza',

        'document'         => 'CPF/CNPJ',

        'certificate'      => 'Certificado',

        'account_id'        => 'Categoria',
        'bank_account_id'   => 'Conta Bancária',

        'due_date'         => 'Vencimento',
        'paid_date'        => 'Data de Pagamento',

        'amount'           => 'Valor',

        'attachment'       => 'Anexo',

        'origin_bank_account_id' => 'Conta Bancária de Origem',
        'target_bank_account_id' => 'Conta Bancária de Destino',

        'date' => 'Data',

        // NFSe Fields
        'client_id'      => 'Cliente',
        'service_id'     => 'Serviço',
        'city_id'        => 'Cidade',
        'iss_retained'   => 'ISS Retido',
        'iss_rate'       => 'Aliquota ISS',
        'operation_type' => 'Natureza da Operação',

        'city_register'  => 'Inscrição Municipal',
        'mirror'         => 'Espelho',

        // generic
        'status'         => 'Status',
        'number'         => 'Número',

        'kind'           => 'Tipo',
        'file'           => 'Arquivo',

        'role'           => 'Papel',
        'email'          => 'Email',


    ],

];
