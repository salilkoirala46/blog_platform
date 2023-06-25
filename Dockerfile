# Base PHP image
FROM php:8.2-apache

# Install MySQLi extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Set the working directory
WORKDIR /var/www/html

# Copy your PHP files to the container
COPY . /var/www/html

# Expose port 80 for web traffic
EXPOSE 80

# Start the PHP development server
CMD ["php", "-S", "0.0.0.0:80"]

