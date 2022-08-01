<html>


<style>
    .title {
        font-size: 20px;
        font-weight: bold;
    }

    .sub-title {
        font-size: 15px;
        font-weight: bold;
    }

    tr {
        border-bottom: 1px solid #ccc;
    }

    th {
        border-bottom: 1px solid #ccc;
        border-right: 1px solid #ccc;
        padding: 5px;
    }

    td {
        border-right: 1px solid #ccc;
        padding: 5px;
        text-align: center;
    }
</style>

<body>
    <p class="title">Olá, {{ $order->customer->name }}!</p>
    <p></p>
    <p class="sub-title">
        Detalhes do pedido
    </p>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->products as $key => $item)
                <tr>
                    <td>
                        {{ $key + 1 }}
                    </td>
                    <td>
                        <img src="{{ $item->photo }}" alt="{{ $item->name }}" width="50">
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>R$ {{ $item->price }}</td>
                    <td>{{ $item->pivot->quantity }}</td>
                    <td>R$ {{ $item->pivot->quantity * $item->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>
        <strong>Total: R$ {{ $totalOrder }}</strong>
    </p>

    <p></p>
    <p>Att, <br>
        Back-end Challenge</p>
    </p>
</body>

</html>
