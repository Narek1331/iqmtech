<x-filament::page>
    <table class="min-w-full divide-y divide-gray-200">
  <thead class="bg-gray-100">
    <tr>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Дата
      </th>
      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        Всего конт-ов
      </th>
      @foreach ($this->getStatuses() as $status)
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ $status->name }}
        </th>
      @endforeach
    </tr>
  </thead>
  <tbody class="bg-white divide-y divide-gray-200">

        @foreach ($this->getDatas() as $num => $datas)
            <tr>
                @foreach ($datas as $data)
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $data }}
                    </td>
                @endforeach
            </tr>
        @endforeach

  </tbody>
</table>

</x-filament::page>

