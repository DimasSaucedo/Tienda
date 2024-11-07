<style>
    .is-invalid {
        border-color: red;
    }
</style>

<div class="modal fade" id="modal-agregar-rin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Rin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" id="agregarRinForm" action="/agregar_rin" method="POST"
                enctype="multipart/form-data" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <label class="form-label">Imagen principal: </label>
                        <input class="form-control" type="file" name="foto_principal" id="foto_principal" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Diametro</label>
                        <select name="diametro" id="diametro" class="form-control" required>
                            <option value="" selected disabled>Selecciona una opción</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="24">24</option>
                            <option value="26">26</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ancho</label>
                        <select name="ancho" id="ancho" class="form-control" required>
                            <option value="" selected disabled>Selecciona una opción</option>
                            <option value="5">5</option>
                            <option value="5.5">5.5</option>
                            <option value="6">6</option>
                            <option value="6.5">6.5</option>
                            <option value="7">7</option>
                            <option value="7.5">7.5</option>
                            <option value="8">8</option>
                            <option value="8.5">8.5</option>
                            <option value="9">9</option>
                            <option value="9.5">9.5</option>
                            <option value="10">10</option>
                            <option value="10.5">10.5</option>
                            <option value="11">11</option>
                            <option value="11.5">11.5</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Barrenación</label>
                        <select name="barrenacion" id="barrenacion" class="form-control" required>
                            <option value="4x100">4x100</option>
                            <option value="4x108">4x108</option>
                            <option value="4x114">4x114</option>
                            <option value="4x114 / 4x108">4x114 / 4x108</option>
                            <option value="4x100 / 4x108">4x100 / 4x108</option>
                            <option value="4x114 / 4x100">4x114 / 4x100</option>
                            <option value="4x130">4x130</option>
                            <option value="5x100">5x100</option>
                            <option value="5x108">5x108</option>
                            <option value="5x110">5x110</option>
                            <option value="5x112">5x112</option>
                            <option value="5x113">5x113</option>
                            <option value="5x114">5x114</option>
                            <option value="5x114 / 5x100">5x114 / 5x100</option>
                            <option value="5x112 / 5x100">5x112 / 5x100</option>
                            <option value="5x120">5x120</option>
                            <option value="5x127">5x127</option>
                            <option value="5x127 / 5x120">5x127 / 5x120</option>
                            <option value="5x127 / 5x135">5x127 / 5x135</option>
                            <option value="5x127 / 5x139">5x127 / 5x139</option>
                            <option value="5x135 / 5x139">5x135 / 5x139</option>
                            <option value="5x135">5x135</option>
                            <option value="5x139">5x139</option>
                            <option value="5x150">5x150</option>
                            <option value="6x114">6x114</option>
                            <option value="6x120">6x120</option>
                            <option value="6x130">6x130</option>
                            <option value="6x135">6x135</option>
                            <option value="6x139">6x139</option>
                            <option value="6x139 / 6x135">6x139 / 6x135</option>
                            <option value="8x170">8x170</option>
                            <option value="8x170 / 8x180">8x170 / 8x180</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Imagen secundaria: </label>
                        <input class="form-control" type="file" name="foto_secundaria" id="foto_secundaria">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fa-solid fa-xmark"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>
                        Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<br>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('agregarRinForm').addEventListener('submit', function(event) {
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
