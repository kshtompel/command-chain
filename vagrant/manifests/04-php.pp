augeas { 'php_config':
    context => '/files/etc/php.ini/PHP',
    notify  => Service[php-fpm],
    changes => [
        'set date.timezone UTC',
        'set memory_limit 128M',
        'set max_execution_time 3600',
        'set short_open_tag off',
        'set upload_max_filesize 128M',
        'set post_max_size 128M'
    ]
}

file { 'php_amqp_extension':
    path      => '/etc/php.d/amqp.ini',
    ensure    => file,
    content   => "extension = /opt/remi/php56/root/usr/lib64/php/modules/amqp.so",
}
