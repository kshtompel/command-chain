class { '::rabbitmq':
    service_manage    => true,
    port              => '5672',
    delete_guest_user => true,
}

# Create users
rabbitmq_user { "${rabbitmq_user_username}":
    admin    => true,
    password => $rabbitmq_user_password,
    ensure   => present
}

# Register VHosts
rabbitmq_vhost { "${rabbitmq_vhost}":
    ensure => present
}

# Add permissions for base user
rabbitmq_user_permissions { "${rabbitmq_user_username}@${rabbitmq_vhost}":
    configure_permission => '.*',
    read_permission      => '.*',
    write_permission     => '.*'
}
