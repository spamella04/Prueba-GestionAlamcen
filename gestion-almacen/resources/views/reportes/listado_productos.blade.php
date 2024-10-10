<!DOCTYPE html>
<html>
<head>
    <title>Listado de Productos por Categoría</title>
</head>
<body>
    <h1>Listado de Productos por Categoría</h1>
    @foreach($productosPorCategoria as $categoria => $productos)
        <h2>{{ $categoria }}</h2>
        <ul>
            @foreach($productos as $producto)
                <li>{{ $producto->nombre }} - Precio: ${{ $producto->precio }} - Stock: {{ $producto->stock }}</li>
            @endforeach
        </ul>
    @endforeach
</body>
</html>

