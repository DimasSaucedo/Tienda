<style>
    .is-invalid {
        border-color: red;
    }
</style>

<div class="modal fade" id="modal-actualizar-{{ $item->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $item->id_rin }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" id="editarRinForm" action="/editar_rin" method="POST"
                enctype="multipart/form-data" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <label class="form-label">Imagen principal: </label>
                        <input class="form-control" type="file" name="foto_principal" id="foto_principal">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Diametro</label>
                        <select name="diametro" id="diametro" class="form-control" required>
                            <option value="" selected disabled>Selecciona una opción</option>
                            <option value="13" @if ($item->diametro == 13) selected @endif>13</option>
                            <option value="14" @if ($item->diametro == 14) selected @endif>14</option>
                            <option value="15" @if ($item->diametro == 15) selected @endif>15</option>
                            <option value="16" @if ($item->diametro == 16) selected @endif>16</option>
                            <option value="17" @if ($item->diametro == 17) selected @endif>17</option>
                            <option value="18" @if ($item->diametro == 18) selected @endif>18</option>
                            <option value="19" @if ($item->diametro == 19) selected @endif>19</option>
                            <option value="20" @if ($item->diametro == 20) selected @endif>20</option>
                            <option value="21" @if ($item->diametro == 21) selected @endif>21</option>
                            <option value="22" @if ($item->diametro == 22) selected @endif>22</option>
                            <option value="24" @if ($item->diametro == 24) selected @endif>24</option>
                            <option value="26" @if ($item->diametro == 26) selected @endif>26</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ancho</label>
                        <select name="ancho" id="ancho" class="form-control" required>
                            <option value="" selected disabled>Selecciona una opción</option>
                            <option value="5" @if ($item->ancho == 5) selected @endif>5</option>
                            <option value="5.5" @if ($item->ancho == 5.5) selected @endif>5.5</option>
                            <option value="6" @if ($item->ancho == 6) selected @endif>6</option>
                            <option value="6.5" @if ($item->ancho == 6.5) selected @endif>6.5</option>
                            <option value="7" @if ($item->ancho == 7) selected @endif>7</option>
                            <option value="7.5" @if ($item->ancho == 7.5) selected @endif>7.5</option>
                            <option value="8" @if ($item->ancho == 8) selected @endif>8</option>
                            <option value="8.5" @if ($item->ancho == 8.5) selected @endif>8.5</option>
                            <option value="9" @if ($item->ancho == 9) selected @endif>9</option>
                            <option value="9.5" @if ($item->ancho == 9.5) selected @endif>9.5</option>
                            <option value="10" @if ($item->ancho == 10) selected @endif>10</option>
                            <option value="10.5" @if ($item->ancho == 10.5) selected @endif>10.5</option>
                            <option value="11" @if ($item->ancho == 11) selected @endif>11</option>
                            <option value="11.5" @if ($item->ancho == 11.5) selected @endif>11.5</option>
                            <option value="12" @if ($item->ancho == 12) selected @endif>12</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Barrenación</label>
                        <select name="barrenacion" id="barrenacion" class="form-control" required>
                            <option value="4x100" @if ($item->barrenacion == '4x100') selected @endif>4x100</option>
                            <option value="4x108" @if ($item->barrenacion == '4x108') selected @endif>4x108</option>
                            <option value="4x114" @if ($item->barrenacion == '4x114') selected @endif>4x114</option>
                            <option value="4x130" @if ($item->barrenacion == '4x130') selected @endif>4x130</option>
                            <option value="5x100" @if ($item->barrenacion == '5x100') selected @endif>5x100</option>
                            <option value="5x108" @if ($item->barrenacion == '5x108') selected @endif>5x108</option>
                            <option value="5x110" @if ($item->barrenacion == '5x110') selected @endif>5x110</option>
                            <option value="5x112" @if ($item->barrenacion == '5x112') selected @endif>5x112</option>
                            <option value="5x113" @if ($item->barrenacion == '5x113') selected @endif>5x113</option>
                            <option value="5x114" @if ($item->barrenacion == '5x114') selected @endif>5x114</option>
                            <option value="5x120" @if ($item->barrenacion == '5x120') selected @endif>5x120</option>
                            <option value="5x127" @if ($item->barrenacion == '5x127') selected @endif>5x127</option>
                            <option value="5x135" @if ($item->barrenacion == '5x135') selected @endif>5x135</option>
                            <option value="5x139" @if ($item->barrenacion == '5x139') selected @endif>5x139</option>
                            <option value="5x150" @if ($item->barrenacion == '5x150') selected @endif>5x150</option>
                            <option value="6x114" @if ($item->barrenacion == '6x114') selected @endif>6x114</option>
                            <option value="6x120" @if ($item->barrenacion == '6x120') selected @endif>6x120</option>
                            <option value="6x130" @if ($item->barrenacion == '6x130') selected @endif>6x130</option>
                            <option value="6x135" @if ($item->barrenacion == '6x135') selected @endif>6x135</option>
                            <option value="6x139" @if ($item->barrenacion == '6x139') selected @endif>6x139</option>
                            <option value="8x170" @if ($item->barrenacion == '8x170') selected @endif>8x170</option>
                            <option value="4x114 / 4x108" @if ($item->barrenacion == '4x114 / 4x108') selected @endif>4x114 /
                                4x108</option>
                            <option value="4x100 / 4x108" @if ($item->barrenacion == '4x100 / 4x108') selected @endif>4x100 /
                                4x108</option>
                            <option value="4x114 / 4x100" @if ($item->barrenacion == '4x114 / 4x100') selected @endif>4x114 /
                                4x100</option>
                            <option value="5x114 / 5x100" @if ($item->barrenacion == '5x114 / 5x100') selected @endif>5x114 /
                                5x100</option>
                            <option value="5x100 / 5x108" @if ($item->barrenacion == '5x100 / 5x108') selected @endif>5x100 /
                                5x108</option>
                            <option value="5x112 / 5x100" @if ($item->barrenacion == '5x112 / 5x100') selected @endif>5x112 /
                                5x100</option>
                            <option value="5x127 / 5x120" @if ($item->barrenacion == '5x127 / 5x120') selected @endif>5x127 /
                                5x120</option>
                            <option value="5x127 / 5x135" @if ($item->barrenacion == '5x127 / 5x135') selected @endif>5x127 /
                                5x135</option>
                            <option value="5x127 / 5x139" @if ($item->barrenacion == '5x127 / 5x139') selected @endif>5x127 /
                                5x139</option>
                            <option value="5x135 / 5x139" @if ($item->barrenacion == '5x135 / 5x139') selected @endif>5x135 /
                                5x139</option>
                            <option value="6x139 / 6x135" @if ($item->barrenacion == '6x139 / 6x135') selected @endif>6x139 /
                                6x135</option>
                            <option value="8x170 / 8x180" @if ($item->barrenacion == '8x170 / 8x180') selected @endif>8x170 /
                                8x180</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Imagen secundaria: </label>
                        <input class="form-control" type="file" name="foto_secundaria" id="foto_secundaria">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="text" id="id" name="id" value="{{ $item->id }}" hidden>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<br>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('editarRinForm').addEventListener('submit', function(event) {
            const form = this;
            const fields = form.querySelectorAll('input[required]');
            let allFilled = true;

            fields.forEach(function(field) {
                if (!field.value) {
                    allFilled = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!allFilled) {
                event.preventDefault();
                event.stopPropagation();

            } else {
                form.classList.add('was-validated');
            }
        });
    });
</script>
