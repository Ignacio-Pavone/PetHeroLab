<?php
use Utils\Session;
$user = Session::GetLoggedUser();
$type = $_SESSION['userType'];
?>
<section class="login-block">
    <main class="py-5">
        <section id="login-block" class="mb-5">
            <form action="<?php echo FRONT_ROOT ?>Guardian/modificarDisponibilidad" method="post">
                <br>
                <center>
                    <h3 class="mb">Modificar Disponibilidad</h3>
                    <hr>
                </center>
                <br>
                <table style="text-align:center;">
                    <thead>
                    <tr>
                        <th style="width: 16%;">Name</th>
                        <th style="width: 16%;">Initial Date</th>
                        <th style="width: 16%;">Last Date</th>
                        <th style="width: 16%;">Working Days</th>
                        <th style="width: 16%;">Pet's size</th>
                    </tr>
                    </thead>
                    <tbody align="center">
                    <tr>
                        <input type="hidden" name="guardianEmail" class="form-control form-control-ml"
                               value=<?php echo $user->getEmail() ?>>
                        <td><?php echo $user->getFullName(); ?></td>
                        <td><input type="date" name="fechaInicio" id="initDate" min="<?php echo date('Y-m-d') ?>">
                        </td>
                        <td><input type="date" name="fechaFin" id="finishDate" min="<?php echo date('Y-m-d') ?>">
                        </td>
                        <td><select name="daysToWork[]" id="daysToWork" multiple="multiple" required>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miercoles">Miercoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sabado">Sabado</option>
                                <option value="Domingo">Domingo</option>
                            </select></td>
                        <td><?php echo $user->getTipoMascota(); ?></td>
                    </tr>
                    </tbody>
                </table>
                <div class="col-lg-1" style="text-align:center">
                    <button type="submit" onclick="return confirm('Are you sure?')" style="text-align:center"
                            class="btn btn-dark">Modificar
                    </button>
                </div>
        </section>
        </div>
        </form>
        <br>
        </div>
        </div>
    </main>