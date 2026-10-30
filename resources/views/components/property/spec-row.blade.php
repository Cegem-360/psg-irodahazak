{{--
    One "Label: value" row of the property specification table.

    <x-property.spec-row :label="__('Address')">{{ $property->cim_varos }}</x-property.spec-row>
--}}
@props(['label'])

<tr>
    <td class="font-bold">{{ $label }}:</td>
    <td>{{ $slot }}</td>
</tr>
