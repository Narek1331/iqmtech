<x-filament::page>
    <table class="min-w-full divide-y divide-gray-200">
  <thead class="bg-gray-100">
    <tr>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Год
      </th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Всего конт-ов
      </th>
      @foreach ($this->getStatuses() as $status)
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ $status->name }}
        </th>
      @endforeach
      {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Лид
      </th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Конверсия в ЛИД
      </th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Перезвонить позже
      </th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Диалог
      </th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Не интересно/сброс
      </th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Другое
      </th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Нет ответа/недоступен
      </th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Нет ответа/недоступен
      </th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        НО/НД 2 день
      </th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        НО/НД 3 день
      </th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Повторный лид
      </th> --}}
    </tr>
  </thead>
  <tbody class="bg-white divide-y divide-gray-200">
    <tr>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ now()->year }}
        </td>
        @foreach ($this->getDatas() as $num => $data)
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $data }}
            </td>
        @endforeach
    </tr>
  </tbody>
</table>

</x-filament::page>

{{-- @dd($this->getData()) --}}
