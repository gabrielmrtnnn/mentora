{{-- MODAL REVIEW POPUP --}}
<div id="reviewModal" class="fixed inset-0 z-[100] hidden" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                
                <form id="reviewForm" action="{{ route('review.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="booking_id" id="modalBookingId">
                    
                    <div class="bg-white px-8 pb-4 pt-8">
                        <div class="flex justify-between items-center mb-5">
                            <h3 class="text-2xl font-bold text-gray-900" id="modal-title">Rate Tutor</h3>
                            <button type="button" onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600 transition">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <p class="text-gray-500 text-sm mb-6">
                            {{ __('Bagaimana pengalaman belajarmu dengan') }} <span id="modalTutorName" class="font-bold text-gray-800">Tutor</span>?
                        </p>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Penilaian') }}</label>
                            <div class="star-rating text-4xl cursor-pointer">
                                <input type="radio" id="star5" name="rating" value="5" class="hidden" required />
                                <label for="star5" class="text-gray-300 transition hover:scale-110">★</label>
                                
                                <input type="radio" id="star4" name="rating" value="4" class="hidden" />
                                <label for="star4" class="text-gray-300 transition hover:scale-110">★</label>
                                
                                <input type="radio" id="star3" name="rating" value="3" class="hidden" />
                                <label for="star3" class="text-gray-300 transition hover:scale-110">★</label>
                                
                                <input type="radio" id="star2" name="rating" value="2" class="hidden" />
                                <label for="star2" class="text-gray-300 transition hover:scale-110">★</label>
                                
                                <input type="radio" id="star1" name="rating" value="1" class="hidden" />
                                <label for="star1" class="text-gray-300 transition hover:scale-110">★</label>
                            </div>
                        </div>

                        <div>
                            <label for="comment" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Ulasan (Opsional)') }}</label>
                            <textarea id="comment" name="comment" rows="4" 
                                      class="block w-full rounded-2xl border-gray-200 shadow-sm focus:border-primary focus:ring-primary sm:text-sm p-4 border bg-gray-50 focus:bg-white transition" 
                                      placeholder="{{ __('Ceritakan pengalamanmu belajar di sesi ini...') }}"></textarea>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50/50 border-t border-gray-100 px-8 py-5 flex justify-end gap-3 rounded-b-3xl">
                        <button type="button" onclick="closeReviewModal()" 
                                class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 font-bold transition">
                            {{ __('Batal') }}
                        </button>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-primary text-white rounded-xl hover:bg-blue-600 font-bold transition shadow-sm hover:shadow-md">
                            {{ __('Kirim Review') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Memasukkan CSS dan Script secara langsung tanpa @push agar dijamin terbaca --}}
<style>
    .star-rating {
        display: flex;
        flex-direction: row-reverse; 
        justify-content: flex-end;
    }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #fbbf24;
    }
</style>

<script>
    function openReviewModal(bookingId, tutorName) {
        document.getElementById('modalBookingId').value = bookingId;
        document.getElementById('modalTutorName').innerText = tutorName;
        
        const modal = document.getElementById('reviewModal');
        // Hapus inline display none
        modal.style.display = ''; 
        // Hapus class hidden bawaan Tailwind
        modal.classList.remove('hidden');
    }

    function closeReviewModal() {
        const modal = document.getElementById('reviewModal');
        // Tambahkan kembali class hidden bawaan Tailwind
        modal.classList.add('hidden');
        // Tambahkan kembali inline display none
        modal.style.display = 'none'; 
        
        document.getElementById('reviewForm').reset();
    }
</script>