<div id="jstree-default">
    @forelse ($listCoa as $parent)
        {{-- orang tua --}}
        <ul>
            <li data-jstree='{"opened":true}'>
                {{ $parent->kode . ' - ' . $parent->nama }}

                @php
                    $childs = \DB::table('coas')
                        ->select('id', 'kode', 'nama')
                        ->where('parent', $parent->id)
                        ->get();
                @endphp

                @foreach ($childs as $child)
                    {{-- anak --}}
                    <ul>
                        <li data-jstree='{"opened":true}'>
                            {{ $child->kode . ' - ' . $child->nama }}

                            @php
                                $grandChilds = \DB::table('coas')
                                    ->select('id', 'kode', 'nama')
                                    ->where('parent', $child->id)
                                    ->get();
                            @endphp

                            @foreach ($grandChilds as $gc)
                                {{-- cucu --}}
                                <ul>
                                    <li>
                                        {{ $gc->kode . ' - ' . $gc->nama }}

                                        @php
                                            $greatGrandChilds = \DB::table('coas')
                                                ->select('id', 'kode', 'nama')
                                                ->where('parent', $gc->id)
                                                ->get();
                                        @endphp

                                        @foreach ($greatGrandChilds as $ggc)
                                            {{-- cicit --}}
                                            <ul>
                                                <li>{{ $ggc->kode . ' - ' . $ggc->nama }}</li>
                                            </ul>
                                            {{-- end of cicit --}}
                                        @endforeach
                                    </li>
                                </ul>
                                {{-- end of cucu --}}
                            @endforeach
                        </li>
                    </ul>
                    {{-- end of anak --}}
                @endforeach
            </li>
        </ul>
        {{-- end of orang tua --}}
    @empty
        <p>Data tidak ditemukan</p>
    @endforelse
</div>
