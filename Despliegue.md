Despliegue EC2 Ubuntu

sudo apt update

sudo apt install -y \
 nginx \
 php8.3 \
 php-fpm \
 php-cli \
 php-mbstring \
 php-xml \
 php-curl


Copiar aplicación:

sudo mkdir -p /var/www/running-zones

sudo rsync -av running-zones/ \
/var/www/running-zones/


Instalar configuración:

sudo cp nginx/runningzones.conf \
/etc/nginx/sites-available/runningzones

sudo ln -s \
/etc/nginx/sites-available/runningzones \
/etc/nginx/sites-enabled/


Verificar:

sudo nginx -t


Reiniciar:

sudo systemctl restart nginx

sudo systemctl restart php8.3-fpm


Abrir puertos en Security Group:

22/TCP
80/TCP
443/TCP


Con esto ya tienes una aplicación PHP funcional, configuración de Nginx y configuración PHP-FPM listas para desplegarse en una EC2 Ubuntu. Para un entorno profesional añadiría también Terraform, Ansible, HTTPS con Let's Encrypt y un pipeline de GitHub Actions para despliegue automático.
