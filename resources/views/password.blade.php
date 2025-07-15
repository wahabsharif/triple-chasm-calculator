@extends('layouts.main')

@section('content')
    <div id="password-modal" class="modal"
        style="display: flex; align-items: center; justify-content: center; position: fixed; z-index: 9999; left: 0; top: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.3); backdrop-filter: blur(8px);">
        <div
            style="background: #fff; padding: 2rem; border-radius: 8px; min-width: 320px; box-shadow: 0 2px 16px rgba(0,0,0,0.2);">
            <h3 style="margin-bottom: 1rem;">Protected Area</h3>
            <form id="password-form">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <input type="password" name="password" id="password-input" class="form-control"
                        placeholder="Enter password" required style="width: 100%; padding: 0.5rem;" />
                </div>
                <div id="password-error" style="color: red; display: none; margin-bottom: 1rem;"></div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('password-modal');
            const form = document.getElementById('password-form');
            const errorDiv = document.getElementById('password-error');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                errorDiv.style.display = 'none';
                fetch("{{ route('password.check') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            password: document.getElementById('password-input').value
                        })
                    })
                    .then(res => res.json().then(data => ({
                        status: res.status,
                        body: data
                    })))
                    .then(({
                        status,
                        body
                    }) => {
                        if (status === 200 && body.success) {
                            // Force a full page reload after successful password
                            window.location.reload();
                        } else {
                            errorDiv.textContent = body.message || 'Incorrect password.';
                            errorDiv.style.display = 'block';
                        }
                    });
            });
        });
    </script>
@endsection
