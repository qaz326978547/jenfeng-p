# 使用官方 PHP 8.1 镜像作为基础镜像
FROM php:8.1-fpm

# 安装必要的 PHP 扩展
RUN docker-php-ext-install pdo pdo_mysql

# 安装 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 设置工作目录
WORKDIR /var/www/html

# 复制项目文件到工作目录
COPY . .

# 执行 Composer Install
RUN composer install --optimize-autoloader --no-dev

# 将所有文件的拥有者设置为 www-data 用户
RUN chown -R www-data:www-data /var/www/html

# 使用 www-data 用户运行进程
USER www-data

# 暴露 PHP-FPM 的默认端口
EXPOSE 9000

# 容器启动命令
CMD ["php-fpm"]
