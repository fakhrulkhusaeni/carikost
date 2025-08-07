<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <!-- <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p> -->
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Avatar Upload -->
        <div>
            <x-input-label for="avatar" :value="__('Foto Profil')" />
            <div class="flex items-center space-x-4">
                <img id="avatar-preview" src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('assets/profile.png') }}"
                    alt="avatar"
                    class="w-16 h-16 rounded-full border border-gray-300">
                <input id="avatar" name="avatar" type="file" class="mt-1 block w-full" accept="image/*">
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Gender -->
        <div>
            <x-input-label for="gender" :value="__('Jenis Kelamin')" />
            <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="" disabled {{ old('gender', $user->gender ?? '') == '' ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                <option value="laki-laki" {{ old('gender', $user->gender ?? '') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="perempuan" {{ old('gender', $user->gender ?? '') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>


        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-gray-200 text-gray-500" :value="old('email', $user->email)" autocomplete="username" readonly/>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __(' Alamat email Anda belum diverifikasi.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __(' Klik di sini untuk mengirim ulang email verifikasi.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <x-text-input id="phone" name="phone" type="text" pattern="[0-9]*" maxlength="13" inputmode="numeric" 
            oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="mt-1 block w-full" :value="old('phone', $user->phone)" required autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 3000)"
                class="text-sm text-green-600">{{ __('Berhasil Disimpan.') }}</p>
            @endif
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if ($errors->has('phone'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Nomor Telepon Sudah Terdaftar',
            text: '{{ $errors->first('phone') }}',
        });
    </script>
    @endif

</section>