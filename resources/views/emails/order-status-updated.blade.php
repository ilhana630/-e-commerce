<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Status Pesanan</title>
<style>
  body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
  .wrapper { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
  .header { background: #198754; color: #fff; padding: 24px 32px; }
  .header h1 { margin: 0; font-size: 22px; }
  .header p { margin: 4px 0 0; opacity: .85; font-size: 14px; }
  .body { padding: 32px; }
  .greeting { font-size: 16px; margin-bottom: 16px; }
  .status-change { display: flex; align-items: center; gap: 16px; background: #f8f9fa; border-radius: 8px; padding: 20px; margin: 20px 0; justify-content: center; }
  .status-badge { display: inline-block; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; }
  .badge-pending  { background: #fff3cd; color: #856404; }
  .badge-paid     { background: #cff4fc; color: #055160; }
  .badge-shipped  { background: #cfe2ff; color: #084298; }
  .badge-done     { background: #d1e7dd; color: #0a3622; }
  .badge-cancelled{ background: #f8d7da; color: #842029; }
  .arrow { font-size: 24px; color: #666; }
  .info-box { background: #f8f9fa; border-left: 4px solid #198754; border-radius: 4px; padding: 16px 20px; margin-bottom: 24px; }
  .info-box p { margin: 6px 0; font-size: 14px; color: #444; }
  .info-box strong { color: #111; }
  .footer { background: #f8f9fa; padding: 20px 32px; text-align: center; font-size: 12px; color: #888; border-top: 1px solid #eee; }
  .btn { display: inline-block; padding: 12px 28px; background: #198754; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 600; margin-top: 20px; }
</style>
</head>
<body>
@php
  $labels = [
    'pending'   => 'Menunggu Pembayaran',
    'paid'      => 'Pembayaran Diterima',
    'shipped'   => 'Sedang Dikirim',
    'done'      => 'Selesai',
    'cancelled' => 'Dibatalkan',
  ];
  $classes = [
    'pending'   => 'badge-pending',
    'paid'      => 'badge-paid',
    'shipped'   => 'badge-shipped',
    'done'      => 'badge-done',
    'cancelled' => 'badge-cancelled',
  ];
  $newStatus = $order->status;
  $messages = [
    'paid'      => 'Pembayaran Anda telah dikonfirmasi. Pesanan akan segera kami proses.',
    'shipped'   => 'Pesanan Anda sedang dalam perjalanan. Harap tunggu kedatangannya.',
    'done'      => 'Pesanan telah selesai. Terima kasih telah berbelanja bersama kami!',
    'cancelled' => 'Mohon maaf, pesanan Anda telah dibatalkan. Hubungi kami jika ada pertanyaan.',
  ];
@endphp
<div class="wrapper">
  <div class="header">
    <h1>Update Status Pesanan</h1>
    <p>Ada perubahan pada pesanan Anda</p>
  </div>

  <div class="body">
    <p class="greeting">Halo, <strong>{{ $order->user->name }}</strong>!</p>
    <p style="color:#555;font-size:14px;">
      {{ $messages[$newStatus] ?? 'Status pesanan Anda telah diperbarui.' }}
    </p>

    <div class="status-change">
      <span class="status-badge {{ $classes[$oldStatus] ?? 'badge-pending' }}">
        {{ $labels[$oldStatus] ?? $oldStatus }}
      </span>
      <span class="arrow">&#8594;</span>
      <span class="status-badge {{ $classes[$newStatus] ?? 'badge-pending' }}">
        {{ $labels[$newStatus] ?? $newStatus }}
      </span>
    </div>

    <div class="info-box">
      <p><strong>No. Pesanan:</strong> #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
      <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
      <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
      <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address }}</p>
    </div>

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
