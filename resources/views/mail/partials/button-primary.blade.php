{{-- Bouton CTA compatible clients mail (styles inline) --}}
@props([
  'href' => '#',
  'label' => '',
])
<table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0;">
  <tr>
    <td align="left">
      <a href="{{ $href }}" style="display:inline-block;padding:14px 26px;background-color:#0f6b57;color:#ffffff !important;text-decoration:none;border-radius:8px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;font-size:15px;font-weight:600;line-height:1.2;box-shadow:0 2px 8px rgba(15,107,87,0.25);">{{ $label }}</a>
    </td>
  </tr>
</table>
