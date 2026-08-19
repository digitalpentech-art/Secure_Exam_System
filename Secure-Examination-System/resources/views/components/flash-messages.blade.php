<div id="flash-messages">
    @if(session('success'))
        <div class="flash-message max-w-7xl mx-auto mt-4 px-6 w-full">
            <div class="bg-green-100 text-green-700 p-4 rounded-lg border border-green-200">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="flash-message max-w-7xl mx-auto mt-4 px-6 w-full">
            <div class="bg-red-100 text-red-700 p-4 rounded-lg border border-red-200">
                {{ session('error') }}
            </div>
        </div>
    @endif
</div>

<script>
    setTimeout(() => {
        document.querySelectorAll('.flash-message').forEach(el => el.style.display = 'none');
    }, 5000);
</script>
