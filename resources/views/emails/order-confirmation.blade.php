<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Konfirmasi Pesanan</title>
<style>
  body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
  .wrapper { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
  .header { background: #0d6efd; color: #fff; padding: 24px 32px; }
  .header h1 { margin: 0; font-size: 22px; }
  .header p { margin: 4px 0 0; opacity: .85; font-size: 14px; }
  .body { padding: 32px; }
  .greeting { font-size: 16px; margin-bottom: 16px; }
  .info-box { background: #f8f9fa; border-left: 4px solid #0d6efd; border-radius: 4px; padding: 16px 20px; margin-bottom: 24px; }
  .info-box p { margin: 6px 0; font-size: 14px; color: #444; }
  .info-box strong { color: #111; }
  table { width: 100%; border-collapse: collapse; font-size: 14px; }
  table th { background: #f1f3f5; padding: 10px 12px; text-align: left; color: #555; font-weight: 600; }
  table td { padding: 10px 12px; border-bottom: 1px solid #eee; color: #333; }
  .total-row td { font-weight: bold; font-size: 15px; background: #f8f9fa; }
  .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #ffc107; color: #333; }
  .footer { background: #f8f9fa; padding: 20px 32px; text-align: center; font-size: 12px; color: #888; border-top: 1px solid #eee; }
  .btn { display: inline-block; padding: 12px 28px; background: #0d6efd; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 600; margin-top: 20px; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>Pesanan Diterima!</h1>
    <p>Terima kasih telah berbelanja di {{ config('app.name') }}</p>
  </div>

  <div class="body">
    <p class="greeting">Halo, <strong>{{ $order->user->name }}</strong>!</p>
    <p style="color:#555;font-size:14px;">Pesanan Anda telah kami terima dan sedang diproses. Berikut ringkasan pesanan Anda:</p>

    <div class="info-box">
      <p><strong>No. Pesanan:</strong> #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
      <p><strong>Tanggal:</strong> {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
      <p><strong>Status:</strong> <span class="badge">Menunggu Pembayaran</span></p>
      <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address }}</p>
      <p><strong>No. Telepon:</strong> {{ $order->phone }}</p>
    </div>

    <table>
      <thead>
        <tr>
          <th>Produk</th>
          <th style="text-align:center">Qty</th>
          <th style="text-align:right">Harga</th>
          <th style="text-align:right">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
        <tr>
          <td>{{ $item->product->name ?? 'Produk Dihapus' }}</td>
          <td style="text-align:center">{{ $item->quantity }}</td>
          <td style="text-align:right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
          <td style="text-align:right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr class="total-row">
          <td colspan="3" style="text-align:right">Total Pembayaran</td>
          <td style="text-align:right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
        </tr>
      </tbody>
    </table>

    <div style="text-align:center">
      <a href="{{ route('orders.show', $order->id) }}" class="btn">Lihat Detail Pesanan</a>
    </div>
  </div>

  <div class="footer">
    <p>Email ini dikirim secara otomatis. Jangan balas email ini.</p>
    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi.</p>
  </div>
</div>
</body>
</html>
