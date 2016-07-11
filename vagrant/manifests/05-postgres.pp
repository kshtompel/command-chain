# PostgreSQL configuration
class { 'postgresql::server':
}

postgresql::server::db { "command-chain":
    user     => "${postgres_username}",
    password => postgresql_password("${postgres_username}", "${postgres_password}"),
}

postgresql::server::extension{ "uuid-ossp":
    database     => "command-chain",
    package_name => "postgresql-contrib"
}
