<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Stock Total</title>
</head>
<body>
    <h1>Reporte de Stock Total y Valor del Inventario</h1>
    <p>Stock Total: {{ $stockTotal }}</p>
    <p>Valor Total del Inventario: ${{ number_format($valorTotalInventario, 2) }}</p>
</body>
</html>
