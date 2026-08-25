<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6 col-lg-5 p-4">
        
        <h2 class="text-center fw-bold mb-5" style="color: #38354a; letter-spacing: 0.5px;">Dudas? Contactanos</h2>

        @if (session()->has('success'))
            <div class="alert alert-success text-center rounded-pill mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit="submit" class="needs-validation" novalidate>
            
            <div class="mb-3">
                <input type="text" wire:model="name" class="form-control form-control-lg rounded-pill px-4 border-0 shadow-sm" placeholder="Nombre completo" style="background-color: #ffffff; color: #6c757d; height: 55px;">
                @error('name') <div class="text-danger small mt-1 ms-3">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <input type="email" wire:model="email" class="form-control form-control-lg rounded-pill px-4 border-0 shadow-sm" placeholder="E-mail" style="background-color: #ffffff; color: #6c757d; height: 55px;">
                @error('email') <div class="text-danger small mt-1 ms-3">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <input type="text" wire:model="phone" class="form-control form-control-lg rounded-pill px-4 border-0 shadow-sm" placeholder="Celular" style="background-color: #ffffff; color: #6c757d; height: 55px;">
                @error('phone') <div class="text-danger small mt-1 ms-3">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <textarea wire:model="message" class="form-control form-control-lg px-4 pt-3 border-0 shadow-sm" placeholder="Tu Mensaje / Consulta" rows="5" style="background-color: #ffffff; color: #6c757d; border-radius: 1.5rem;"></textarea>
                @error('message') <div class="text-danger small mt-1 ms-3">{{ $message }}</div> @enderror
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-lg rounded-pill px-5 text-white fw-bold shadow-sm" style="background-color: #7c73f6; height: 50px; min-width: 180px;">
                    <i class="bi bi-send-fill me-2"></i> ENVIAR
                </button>
            </div>

        </form>
    </div>
</div>