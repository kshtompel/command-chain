# RabbitMQ variables
$rabbitmq_user_username = hiera('rabbitmq_user_username')
$rabbitmq_user_password = hiera('rabbitmq_user_password')
$rabbitmq_vhost = "/"

# PostgreSQL variables
$postgres_username = hiera('postgres_username')
$postgres_password = hiera('postgres_password')

# PHP variables
$php_packages = hiera_array('php::packages')

# Paths
$bin_dir = hiera('bin_dir')
$source_dir = hiera('source_dir')

# Users
$php_fpm_user = hiera('php_fpm_user')
$php_fpm_group = hiera('php_fpm_group')