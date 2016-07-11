class { 'redis':
    bind      => '127.0.0.1',
    maxmemory => '256mb'
}