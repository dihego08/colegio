<form action="index.php?action=nuevo" method="post">
  <div class="form-group">
    <label for="start">Fecha de inicio</label>
    <div class="input-group date" id="datetimepicker1">
      <input type="text" name="start" class="form-control" readonly /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
    </div>
  </div>

  <div class="form-group">
    <label for="end">Fecha de finalización</label>
    <div class="input-group date" id="datetimepicker2">
      <input type="text" name="end" class="form-control" readonly /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
    </div>
  </div>

  <div class="form-group">
    <label for="class">Tipo de evento</label>
    <select class="form-control" name="class">
      <option value="event-info">Información</option>
      <option value="event-success">Completado</option>
      <option value="event-important">Importantante</option>
      <option value="event-warning">Advertencia</option>
      <option value="event-special">Especial</option>
    </select>
  </div>

  <div class="form-group">
    <label for="title">Título</label>
    <input type="text" name="title" class="form-control" placeholder="Introduce un título" autocomplete="off" required>
  </div>

  <div class="form-group">
    <label for="body">Descripción</label>
    <textarea name="body" class="form-control" required></textarea>
  </div>

  <div class="form-group">
    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-calendar"></span> Nuevo evento</button>
  </div>
</form>