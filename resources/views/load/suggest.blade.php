@php
if (Session::has('language'))
	{
		$language = DB::table('languages')->find(Session::get('language'));
	}
else
	{
		$language = DB::table('languages')->where('is_default','=',1)->first();
	}
@endphp
@foreach($prods as $prod)
	@if ($language->id == $prod->language_id)
	<div class="docname suggestion-item">
		<a href="{{ route('front.product', $prod->slug) }}" style="display: flex; align-items: center; width: 100%; text-decoration: none;">
			<img class="suggestion-image" src="{{ asset('assets/images/thumbnails/'.$prod->thumbnail) }}" alt="{{ $prod->translated_name }}">
			<div class="search-content suggestion-content">
				<p class="suggestion-title">{!! mb_strlen($prod->translated_name,'UTF-8') > 66 ? str_replace($slug,'<b>'.$slug.'</b>',mb_substr($prod->translated_name,0,66,'UTF-8')).'...' : str_replace($slug,'<b>'.$slug.'</b>',$prod->translated_name)  !!} </p>
				<span class="suggestion-price">{{ $prod->showPrice() }}</span>
			</div>
		</a>
	</div>
	@endif
@endforeach
