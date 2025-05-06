<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            margin: 6cm 3cm 2.5cm 3cm;
            /* superior, derecha, inferior, izquierda */
        }

        body {
            body {
                font-family: 'Times New Roman', serif;
                font-size: 12pt;
                /* Tamaño de fuente */
                line-height: 2.0;
                /* Espaciado entre líneas */
                font-weight: normal;
                /* Asegúrate de que sea normal */
            }
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        header {
            position: fixed;
            top: -5cm;
            /* Mantiene el encabezado fuera de la vista */
            left: 0;
            right: 0;
            height: 50px;
            /* Altura del encabezado */
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: -50px;
            /* Mantiene el pie de página fuera de la vista */
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <div>
            <table class="custom-table" style="border-collapse: collapse; width: 100%;">
                <tr>
                    <td style="font-size: 10pt; width: 6.5cm; text-align: center; vertical-align: middle;">
                        Elaboró: Comité de Archivo
                    </td>
                    <td style="font-size: 10pt; width: 1.5cm; text-align: center; vertical-align: middle;" colspan="3">
                        Aprobó: Comité de Archivo
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 10pt; width: 6.5cm; text-align: center; vertical-align: middle;"
                        rowspan="3">
                        <img src="{{ public_path('images/logoucp.png') }}" alt="Logo Universidad"
                            style="width: 6.5cm; height: 2.1cm;">
                    </td>
                    <td style="font-size: 10pt; width: 1.5cm; text-align: center; font-weight: bold; padding: 7px; vertical-align: middle;"
                        colspan="3">
                        SECRETARÍA GENERAL
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 10pt; width: 1.5cm; text-align: center; font-weight: bold; padding: 7px; vertical-align: middle;"
                        colspan="3">
                        GESTIÓN DOCUMENTAL
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 10pt; width: 1.5cm; text-align: center; font-weight: bold; padding: 7px; vertical-align: middle;"
                        colspan="3">
                        FORMATO ACTA
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 8pt; width: 6.5cm; text-align: center;  vertical-align: middle;">
                        Fecha elaboración de formato: 13 septiembre de 2013
                    </td>
                    <td style="font-size: 8pt; width: 1.5cm; text-align: center;  vertical-align: middle;">
                        ED-3
                    </td>
                    <td style="font-size: 8pt; width: 2cm; text-align: center; vertical-align: middle;">
                    </td>
                    <td style="font-size: 8pt; width: 5cm; text-align: center;  vertical-align: middle;">
                        GD-ADM-F-01
                    </td>
                </tr>
            </table>
        </div>

    </header>

    <main>
        <div>
            <strong>ACTA COMITÉ BÁSICO DE FACULTAD</strong>
            <p><strong>{{ $acta->identificacion }}</strong></p>

            <!-- Mostrar la fecha de la reunión formateada en español -->
            <p>FECHA: {{ \Carbon\Carbon::parse($acta->fecha_reunion)->locale('es')->isoFormat('D MMMM YYYY') }}<br></p>

            <!-- Mostrar la hora inicial y final de la reunión, en formato de 12 horas -->
            <p>
                HORA INICIAL: {{ strtolower(\Carbon\Carbon::parse($acta->hora_inicial)->format('h:i A')) }} HORA FINAL:
                {{ strtolower(\Carbon\Carbon::parse($acta->hora_final)->format('h:i A')) }}
            </p>

            <!-- Mostrar el lugar de la reunión -->
            <p>LUGAR: {{ $acta->lugar_reunion }}</p>
            <p></p>

            <!-- Encabezado para la lista de asistentes -->
            <p><strong>ASISTENTES:</strong></p>
            <p></p>

            <!-- Iterar sobre los asistentes y mostrar su nombre y cargo -->
            @foreach ($acta->asistentes as $asistente)
                <p style="text-transform: uppercase;">{{ $asistente->nombre }}</p>
                <p>{{ $asistente->cargo }}</p>
                <p></p>
            @endforeach

            <!-- Verificar si hay ausentes y mostrar la sección correspondiente -->
            @if ($acta->ausentes->count() === 1 && $acta->ausentes[0]->nombre === null)
                <p><strong>AUSENTES:</strong></p>
                <p>N/A</p>
                <p></p>
            @else
                <p><strong>AUSENTES:</strong></p>
                <p></p>
                <!-- Iterar sobre los ausentes y mostrar su nombre y cargo -->
                @foreach ($acta->ausentes as $ausente)
                    <p style="text-transform: uppercase;">{{ $ausente->nombre }}</p>
                    <p>{{ $ausente->cargo }}</p>
                    <p></p>
                @endforeach
            @endif

            <!-- Verificar si hay invitados y mostrar la sección correspondiente -->
            @if ($acta->invitados->count() === 1 && $acta->invitados[0]->nombre === null)
                <p><strong>INVITADOS:</strong></p>
                <p>N/A</p>
                <p></p>
            @else
                <p><strong>INVITADOS:</strong></p>
                <p></p>
                <!-- Iterar sobre los invitados y mostrar su nombre y cargo -->
                @foreach ($acta->invitados as $invitado)
                    <p style="text-transform: uppercase;">{{ $invitado->nombre }}</p>
                    <p>{{ $invitado->cargo }}</p>
                    <p></p>
                @endforeach
            @endif

            <!-- Encabezado para el orden del día -->
            <p><strong>ORDEN DEL DÍA:</strong></p>

            <!-- Iterar sobre los puntos del orden del día y mostrarlos con un prefijo numérico -->
            @foreach ($acta->orden_del_dia as $index => $orden)
                @php
                    // Crear el prefijo numérico con un punto y seis espacios
                    $numeroPrefijo = $index + 1 . '.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                @endphp
                <p style="text-transform: uppercase; line-height: 1.0;">
                    {!! $numeroPrefijo !!}{{ $orden->nombre }}
                </p>
            @endforeach

            <!-- Romper la página antes de continuar con el contenido siguiente -->
            <div style="page-break-before: always;"></div>


            @foreach ($acta->orden_del_dia as $index => $orden)
                @php
                    // Crear el prefijo numérico con un punto y dos espacios
                    $numeroPrefijo = $index + 1 . '.&nbsp;&nbsp;';
                @endphp
                <p style="text-transform: uppercase; line-height: 2.0; text-align: center;">
                    <strong>{!! $numeroPrefijo !!}{{ $orden->nombre }}</strong>
                </p>

                @php
                    // Divide la descripción por saltos de línea para identificar los párrafos
                    $items = explode("\n", $orden->descripcion);
                    $isListOpen = false; // Bandera para verificar si estamos dentro de una lista
                @endphp

                @foreach ($items as $item)
                    @php
                        $trimmedItem = trim($item); // Elimina espacios en blanco al inicio y final del texto
                        // Verifica si el párrafo comienza con "●"
                        $isListItem = str_starts_with($trimmedItem, '●');
                    @endphp

                    @if ($isListItem)

                        @if (!$isListOpen)
                            <!-- Si no hemos comenzado una lista -->
                            @php $isListOpen = true; @endphp <!-- Cambiamos el estado a que estamos dentro de una lista-->
                            <ul> <!-- Abrimos la lista desordenada -->
                        @endif
                        <li>{!! nl2br(e(substr($trimmedItem, 3))) !!}</li> <!-- Añadimos el ítem a la lista, omitiendo el símbolo "●" -->
                    @else
                        <!-- Si no es un ítem de lista -->
                        @if ($isListOpen)
                            <!-- estábamos dentro de una lista -->
                            </ul> <!-- Cerramos la lista -->
                            @php $isListOpen = false; @endphp <!-- Cambiamos el estado a que ya no estamos en una lista-->
                        @endif
                        <p>{!! nl2br(e($trimmedItem)) !!}</p> <!-- Mostramos el párrafo como texto normal -->
                    @endif
                @endforeach

                @if ($isListOpen)
                    <!-- Si al final del bucle seguimos dentro de una lista -->
                    </ul> <!-- Cerramos la lista -->
                @endif
                <p></p> <!-- Espacio adicional entre las secciones -->
            @endforeach


            <p><strong>Fecha próximo Comité Básico de Facultad: </strong>{{ $acta->proxima_reunion }} </p>
            <p></p>

            @foreach ($acta->asistentes as $asistente)
                @php
                    // Busca el usuario que tiene el mismo nombre que el asistente
                    $user = \App\Models\User::where('name', $asistente->nombre)->first();
                @endphp

                @if ($user)
                    <!-- Solo muestra si se encontró el usuario -->
                    @php
                        $firmaPath = 'storage/' . $user->firma; // Ruta relativa
                    @endphp

                    <div>
                        <!-- Mostrar la imagen usando la ruta relativa -->
                        <img src="{{ $firmaPath }}" alt="Firma de {{ $asistente->nombre }}"
                            style="width: 200px; height: 100px; display: block; margin: 0 auto; border-bottom: 2px solid black;">
                        <p style="text-transform: uppercase;"><strong>{{ $asistente->nombre }}</strong></p>
                        <p>{{ $asistente->cargo }}</p>
                    </div>
                @else
                    <p>No se encontró la firma para {{ $asistente->nombre }}</p>
                @endif
                <p></p>
            @endforeach

        </div>

    </main>

    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Times New Roman", "normal"); // Asegúrate de usar "normal"
                $pdf->text(330, 149, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 8);
            ');
        }
        </script>

</body>

</html>
