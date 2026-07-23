@php
    $inputClass = 'w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-600 focus:outline-none';
    $textareaClass = 'w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-600 focus:outline-none';

    $form = $form ?? [];
@endphp

<form
    action="{{ $action }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

    @if($method === 'PUT')
        @method('PUT')
    @endif

    {{-- ===================== --}}
    {{-- INFORMASI RUMAH --}}
    {{-- ===================== --}}

    <div class="bg-white rounded-3xl shadow p-6">

        <h2 class="text-2xl font-bold mb-6">Informasi Rumah Adat</h2>

        <div class="grid md:grid-cols-2 gap-5">

            <div>
                <label class="font-semibold">Nama Rumah</label>

                <input
                    type="text"
                    name="nama"
                    class="{{ $inputClass }}"
                    value="{{ old('nama',$form['nama'] ?? '') }}"
                    required>
            </div>

            <div>
                <label class="font-semibold">Jorong</label>

                <select
                    name="jorong_id"
                    class="{{ $inputClass }}"
                    required>

                    <option value="">
                        Pilih Jorong
                    </option>

                    @foreach($jorongList as $jorong)

                        <option
                            value="{{ $jorong->id_jorong }}"
                            @selected(old('jorong_id',$form['jorong_id'] ?? '')==$jorong->id_jorong)>

                            {{ $jorong->nama_jorong }}

                        </option>

                    @endforeach

                </select>
            </div>

            <div>

                <label class="font-semibold">Suku</label>

                <select
                    name="suku_id"
                    class="{{ $inputClass }}"
                    required>

                    <option value="">Pilih Suku</option>

                    @foreach($sukuList as $suku)

                        <option
                            value="{{ $suku->id_suku }}"
                            @selected(old('suku_id',$form['suku_id'] ?? '')==$suku->id_suku)>

                            {{ $suku->nama_suku }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div>

                <label class="font-semibold">Status</label>

                <select
                    name="status_id"
                    class="{{ $inputClass }}"
                    required>

                    @foreach($statusList as $status)

                        <option
                            value="{{ $status['value'] }}"
                            @selected(old('status_id',$form['status_id'] ?? '')==$status['value'])>

                            {{ $status['label'] }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div>

                <label class="font-semibold">Tahun Dibangun</label>

                <input
                    type="text"
                    name="tahun_dibangun"
                    class="{{ $inputClass }}"
                    value="{{ old('tahun_dibangun',$form['tahun_dibangun'] ?? '') }}">

            </div>

        </div>

        <div class="mt-5">

            <label class="font-semibold">Alamat</label>

            <textarea
                name="alamat"
                rows="4"
                class="{{ $textareaClass }}">{{ old('alamat',$form['alamat'] ?? '') }}</textarea>

        </div>

    </div>

    {{-- ===================== --}}
    {{-- LOKASI --}}
    {{-- ===================== --}}

    <div class="bg-white rounded-3xl shadow p-6">

        <h2 class="text-2xl font-bold mb-6">Lokasi Rumah</h2>

        <div class="grid md:grid-cols-2 gap-5">

            <div>

                <label class="font-semibold">Latitude</label>

                <input
                    type="text"
                    name="latitude"
                    class="{{ $inputClass }}"
                    value="{{ old('latitude',$form['latitude'] ?? '') }}">
            </div>

            <div>

                <label class="font-semibold">Longitude</label>

                <input
                    type="text"
                    name="longitude"
                    class="{{ $inputClass }}"
                    value="{{ old('longitude',$form['longitude'] ?? '') }}">
            </div>
        </div>
    </div>

    {{-- ===================== --}}
    {{-- SEJARAH --}}
    {{-- ===================== --}}

    <div class="bg-white rounded-3xl shadow p-6">

        <h2 class="text-2xl font-bold mb-6">
            Sejarah Rumah Adat
        </h2>

        <textarea
            name="sejarah"
            rows="10"
            class="{{ $textareaClass }}">{{ old('sejarah',$form['sejarah'] ?? '') }}</textarea>

    </div>
    {{-- ===================== --}}
    {{-- GALERI FOTO --}}
    {{-- ===================== --}}

    <div class="bg-white rounded-3xl shadow p-6">

        <div class="flex justify-between items-center mb-5">

            <h2 class="text-2xl font-bold">
                Galeri Foto
            </h2>

            <label
                for="galeri_files"
                class="cursor-pointer bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-xl"> + Tambah Foto
            </label>
        </div>

        <input
            id="galeri_files"
            type="file"
            name="galeri[]"
            accept="image/*"
            multiple
            class="hidden">

        <div
            id="galleryPreview"
            class="grid md:grid-cols-4 gap-4">
        </div>

    </div>


    {{-- ===================== --}}
    {{-- VIDEO --}}
    {{-- ===================== --}}

    <div class="bg-white rounded-3xl shadow p-6">

        <h2 class="text-2xl font-bold mb-6"> Video Rumah Adat </h2>
        <div class="grid md:grid-cols-2 gap-6">

            <div>
                <label class="font-semibold">Judul Video </label>

                <input
                    type="text"
                    name="video_judul"
                    class="{{ $inputClass }}"
                    value="{{ old('video_judul',$form['video_judul'] ?? '') }}">

            </div>

            <div>

                <label class="font-semibold">Upload Video </label>

                <input
                    id="video_file"
                    type="file"
                    name="video_file"
                    accept="video/mp4,video/webm,video/mov"
                    class="{{ $inputClass }}">

            </div>

        </div>

        <div class="mt-6">

            <video

                id="videoPreview"

                controls

                class="hidden w-full rounded-xl border">

            </video>

        </div>

    </div>


    {{-- ===================== --}}
    {{-- BUTTON --}}
    {{-- ===================== --}}

    <div class="flex justify-between">

        <a
            href="{{ route('admin.rumah.index') }}"
            class="px-6 py-3 rounded-xl border">
            Batal
        </a>

        <button
            type="submit"
            class="px-8 py-3 rounded-xl bg-green-700 hover:bg-green-800 text-white">
            {{ $mode == 'edit' ? 'Update Rumah Adat' : 'Simpan Rumah Adat' }}
        </button>

    </div>
</form>

	@push('scripts')

	<script>
		const galleryInput=document.getElementById('galeri_files');
		const galleryPreview=document.getElementById('galleryPreview');

		if(galleryInput){
		galleryInput.addEventListener('change',function(){
		galleryPreview.innerHTML='';
		[...this.files].forEach(file=>{
		const reader=new FileReader();
		reader.onload=function(e){
		galleryPreview.innerHTML+=`
		<div class="rounded-xl overflow-hidden border">

		<img
		src="${e.target.result}"
		class="h-44 w-full object-cover">

		<div class="p-2 text-xs truncate">

		${file.name}

			</div>
		</div>

		`;

		}

		reader.readAsDataURL(file);

		});

		});

		}

		const videoInput=document.getElementById('video_file');
		const videoPreview=document.getElementById('videoPreview');

		if(videoInput){
		videoInput.addEventListener('change',function(){
		const file=this.files[0];
		
		if(!file)return;
		videoPreview.src=URL.createObjectURL(file);
		videoPreview.classList.remove('hidden');

		});

		}

	</script>

	@endpush
</form>