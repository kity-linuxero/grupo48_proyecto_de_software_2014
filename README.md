# Trabajo práctico: Grupo 48 - Proyecto de software 2014
#### Facultad de informática | UNLP

## Banco Alimentario La Plata

Este es un software desarrollado por [Cristian Giambruni](https://github.com/kity-linuxero) y [Ezequiel F. Gómez](https://github.com/egother) para la materia Proyecto de Software año 2014.

### ¿Cómo usarlo?

1. Instalar docker y docker-compose
2. Bajar el repositorio
```bash
git clone https://github.com/kity-linuxero/grupo48_proyecto_de_software_2014 proyecto2014
```
3. Ejecutar contenedores
```bash
cd proyecto2014
docker-compose up -d
```

4. Acceder desde el navegador vía [http://localhost:8090](http://localhost:8090)

### Usuarios

- **Administrador:** Puede hacer todas las operaciones (aquellas del rol de Gestión
más manejo de usuarios y configuraciones del sistema).
  - User: `admin`
  - Pass: `admin`
- **Gestión:** Puede agregar y modificar pedidos modelo, envíos, turnos de entrega y
entregas directas, así como también se le visualizarán las alertas y podrá
consultar los listados de alimentos en stock.
  - User: `gestion`
  - Pass: `gestion`

- **Consulta:** Puede listar los alimentos en stock y consultar los listados y estadísticas.
  - User: `consulta`
  - Pass: `consulta`


