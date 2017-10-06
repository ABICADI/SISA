<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain El default error messages used by
    | the validator class. Some of Else rules have multiple versions such
    | as El size rules. Feel free to tweak each of Else messages here.
    |
    */

                
    'accepted'             => 'Es necesario aceptar.',
    'active_url'           => 'URL inválida.',
    'after'                => 'La fecha debe de ser mayor a :fecha.',
    'after_or_equal'       => 'La fecha debe de ser mayor o igual a :fecha.',
    'alpha'                => 'Solo se permiten ingresar letras.',
    'alpha_dash'           => 'Solo se permiten ingresar letras, número o guíones.',
    'alpha_num'            => 'Solo se permiten ingresar letras y números.',
    'array'                => 'Es necesario ingresar más de un registro.',
    'before'               => 'La fecha debe ser menor a :fecha.',
    'before_or_equal'      => 'La fecha debe ser menor o igual a :fecha.',
    'between'              => [
        'numeric' => 'Solo se permiten ingresar un mínimo :min y un máximo de :max numeros.',
        'file'    => 'El archivo tiene que ser mayor a :min y un menor de :max kilobytes.',
        'string'  => 'Solo se permiten ingresar un mínimo de :min y un máximo de :max caracteres.',
        'array'   => 'Solo se permiten ingresar un mínimo de :min y un máximo de :max detalles.',
    ],
    'boolean'              => 'Solo se permite ingresar verdadero o falso.',
    'confirmed'            => 'La confirmación no coincide.',
    'date'                 => 'La fecha ingresada es una fecha no válida.',
    'date_format'          => 'Los datos no coinciden con el formato :formato.',
    'different'            => 'El registro debe ser diferente.',
    'digits'               => 'El registro debe tener :digits dígitos.',
    'digits_between'       => 'El rango  debe estar entre un mínimo de :min y un máximo de :max dígitos.',
    'dimensions'           => 'Las dimensiones de la imagen no son válidas.',
    'distinct'             => 'El registro tiene un valor duplicado.',
    'email'                => 'Solo se permiten ingresar correos electronicos.',
    'exists'               => 'El registro seleccionado no existe.',
    'file'                 => 'Solo se permite ingresar archivos.',
    'filled'               => 'El registro no puede estar vacio.',
    'image'                => 'El archivo debe ser una imagen.',
    'in'                   => 'El registro seleccionado no es válido.',
    'in_array'             => 'El registro no existe en el grupo :oElr.',
    'integer'              => 'Solo se permiten números.',
    'ip'                   => 'Solo se permiten ingresar direcciones IP válidas.',
    'json'                 => 'El atributo debe ser una cadena JSON válida.',
    'max'                  => [
        'numeric' => 'El número no puede ser mayor a :max.',
        'file'    => 'El archivo no puede ser mayor a :max kilobytes.',
        'string'  => 'El registro no puede ser mayor a :max caracteres.',
        'array'   => 'La lista no debe tener mas de :max registros.',
    ],
    'mimes'                => 'Debe ser un archivo tipo: :valor.',
    'mimetypes'            => 'Debe ser un archivo tipo: :valor.',
    'min'                  => [
        'numeric' => 'El número debe ser menor a :min.',
        'file'    => 'El archivo debe ser menor a :min kilobytes.',
        'string'  => 'El registro debe ser menor a :min caracteres.',
        'array'   => 'La lista debe ser menor a :min detalle.',
    ],
    'not_in'               => 'El archivo seleccionado es invalido.',
    'numeric'              => 'Solo se permite un número.',
    'present'              => 'El registro debe de existir.',
    'regex'                => 'El registro no es válido.',
    'required'             => 'Campo Obligatorio (*).',
    'required_if'          => 'El registro es necesario cuando :oElr es :valor.',
    'required_unless'      => 'El registro field se requiere que :oElr este en :valor.',
    'required_with'        => 'El registro es necesario cuando :valor existe.',
    'required_with_all'    => 'El registro es necesario cuando :valor existe.',
    'required_without'     => 'El registro es necesario cuando :valor no existe.',
    'required_without_all' => 'El registro es necesario cuando ninguno de los :valores existen.',
    'same'                 => 'El registro y :oElr deben coincidir.',
    'size'                 => [
        'numeric' => 'Solo se permite :número.',
        'file'    => 'El archivo debe ser : kilobytes.',
        'string'  => 'El registro debe contener :número caracteres.',
        'array'   => 'La lista debe contener :número de detalles.',
    ],
    'string'               => 'El registro debe ser una cadena.',
    'timezone'             => 'El registro debe ser una zona válida.',
    'unique'               => 'El registro ya se ha tomado.',
    'uploaded'             => 'El archivo no se pudo subir.',
    'url'                  => 'La dirección es URL invalida.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attribute using El
    | convention "attribute.rule" to name El lines. This makes it quick to
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
    | El following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];