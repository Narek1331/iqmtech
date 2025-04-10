<div class="grid flex-1 auto-cols-fr gap-y-8">
    <section x-data="{ isCollapsed: false }" class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="grid flex-1 gap-y-1">
                    <h3 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                        Код для подключения нашего сервиса
                    </h3>
                </div>
            </div>
        </header>

        <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
            <div class="fi-section-content p-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="text-xl font-semibold">Ваш токен</h2>
                        <div class="flex items-start bg-gray-100 dark:bg-gray-800 p-3 rounded-md overflow-x-auto mt-2">
                            <pre id="user-token" class="whitespace-nowrap flex-1">
                                <code>
                                    {{$this->record->token}}
                                </code>
                            </pre>
                            <button type="button" onclick="copyToClipboard('user-token', this)" class="ml-2 text-gray-500 p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition bg-transparent" title="Скопировать">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 copy-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-6 8h6a2 2 0 002-2V7a2 2 0 00-2-2h-6a2 2 0 00-2 2v11z"></path>
                                </svg>
                            </button>
                        </div>

                        <h2 class="text-xl font-semibold mt-4">Вставка кода в ваш сайт</h2>
                        <p>1. Откройте HTML-файл вашего сайта.</p>
                        <p>2. Найдите секцию перед <code>&lt;/body&gt;</code> и вставьте туда этот код.</p>

                        <div class="flex items-start bg-gray-100 dark:bg-gray-800 p-3 rounded-md overflow-x-auto mt-2">
                            <pre id="script-code" class="whitespace-nowrap flex-1">
                                <code>&lt;script token="{{$this->record->token}}" src="{{env('APP_URL')}}/js/client.js"&gt;&lt;/script&gt;</code>
                            </pre>
                            <button type="button" onclick="copyToClipboard('script-code', this)" class="ml-2 text-gray-500 p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition bg-transparent" title="Скопировать">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 copy-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-6 8h6a2 2 0 002-2V7a2 2 0 00-2-2h-6a2 2 0 00-2 2v11z"></path>
                                </svg>
                            </button>
                        </div>

                        <h3 class="text-green-600 font-semibold mt-3">✅ Готово! Ваш сайт подключен.</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function copyToClipboard(id, button) {
        const element = document.getElementById(id);
        const text = element.innerText.trim();

        navigator.clipboard.writeText(text).then(() => {
            const originalIcon = button.innerHTML;

            button.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>
            `;

            setTimeout(() => {
                button.innerHTML = originalIcon;
            }, 2000);
        }).catch(err => {
            console.error("Ошибка копирования:", err);
        });
    }
</script>
