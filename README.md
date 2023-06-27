El proyect esta realizado con contenedores de docker

Para subir el contenedor una vez se tenga instalado los paquetes de composer

<code>sail up -d</code>

una vez los contenedores esten arriba ejecutar

<code>sail npm run build</code>

Optional

Ejecutar el siguiente codigo si se desea generar datos aleatorios

<code>sail php artisan db:seed</code>
