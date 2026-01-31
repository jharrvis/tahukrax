<!DOCTYPE html>
<html lang="id" class="h-full bg-stone-50 dark:bg-[#0f0c0a]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil | RCGO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Russo+One&family=Space+Grotesk:wght@400;700&display=swap');

        body {
            font-family: 'Space Grotesk', sans-serif;
        }

        .font-stencil {
            font-family: 'Black Ops One', system-ui;
        }

        .font-rugged {
            font-family: 'Russo One', sans-serif;
        }
    </style>
</head>

<body class="h-full text-stone-900 dark:text-stone-200 antialiased flex flex-col justify-center items-center p-6">

    <div class="max-w-2xl w-full bg-gray-900 rounded-3xl border border-gray-800 shadow-2xl overflow-hidden"
        data-aos="fade-up">
        <div class="bg-orange-500 p-8 text-center checker-bg">
            <div
                class="inline-flex items-center justify-center w-20 h-20 bg-black rounded-full mb-4 border-2 border-black/20">
                <i class="fas fa-check text-4xl text-orange-500"></i>
            </div>
            <h1 class="font-black text-3xl text-black uppercase">PESANAN DITERIMA!</h1>
            <p class="text-black font-black uppercase tracking-widest text-xs mt-2 opacity-80">Nomor Order:
                #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>

        <div class="p-8">
            <div class="mb-8">
                <h2 class="font-rugged text-xl mb-4 border-b-2 border-stone-100 dark:border-stone-800 pb-2">Detail
                    Amunisi</h2>
                @foreach($order->orderItems as $item)
                    @if($item->item_type == 'package' && $item->package)
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-stone-500 italic">Paket: {{ $item->package->name }}
                                (x{{ $item->quantity }})</span>
                            <span class="font-bold text-lg">Rp
                                {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @elseif(($item->item_type == 'addon' || $item->addon_id) && $item->addon)
                        <div class="flex justify-between items-center text-sm mb-1 ml-4">
                            <span class="text-stone-400 italic">+ {{ $item->addon->name }} (x{{ $item->quantity }})</span>
                            <span class="font-bold text-stone-500">Rp
                                {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endif
                @endforeach

                <div class="flex justify-between items-center text-sm mt-4 text-stone-400">
                    <span class="italic">Ongkos Kirim Estimasi</span>
                    <span class="font-bold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>

                <div
                    class="flex justify-between items-center mt-6 pt-4 border-t-2 border-dashed border-stone-200 dark:border-stone-800">
                    <span class="font-rugged text-xl uppercase">Total Tagihan</span>
                    <span class="font-rugged text-3xl text-[#ff6b00]">Rp
                        {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-stone-50 dark:bg-black/40 p-6 rounded-xl border border-stone-200 dark:border-stone-800">
                <h3 class="font-bold text-sm uppercase mb-3 flex items-center gap-2 text-[#ff6b00]">
                    <i class="fas fa-wallet"></i> Instruksi Pembayaran
                </h3>
                <p class="text-sm text-stone-500 leading-relaxed mb-4 italic">
                    Pesanan Anda saat ini berstatus <span class="text-warning font-bold">PENDING</span>. Silakan
                    selesaikan pembayaran melalui Virtual Account Xendit yang akan dikirimkan ke WhatsApp Anda.
                </p>

                <div class="flex flex-col gap-4">
                    <a href="/admin"
                        class="w-full py-4 btn-cta-primary text-black font-black text-center rounded-full hover:scale-105 transition uppercase tracking-widest shadow-lg">
                        CEK DASHBOARD MITRA
                    </a>
                    <a href="/"
                        class="w-full py-3 text-gray-500 font-bold text-center rounded hover:text-white transition uppercase tracking-widest text-sm">
                        KEMBALI KE BERANDA
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-stone-100 dark:bg-black/60 px-8 py-4 text-center">
            <p class="text-[10px] text-stone-500 font-black uppercase tracking-[0.2em]">
                BUTUH BANTUAN? HUBUNGI COMMAND CENTER (WA): 0812-XXXX-XXXX
            </p>
        </div>
    </div>

    <script>
        // Clear cart after successful order
        document.addEventListener('DOMContentLoaded', function () {
            localStorage.removeItem('rcgo_cart_v4');
            if (window.RCGOCart) {
                // If using global object
                window.RCGOCart.set([], {});
            }
        });
    </script>
</body>

</html>