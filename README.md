
# Описание
<ol>
  <li>В папку files кладём файлы, в которых нужно искать</li>
  <li>Файлы отображаются на странице</li>
</ol>
# Требования
<ol>
  <li>Формат файла: ключ1\tзначение1\x0Aключ2\tзначение2\x0A...ключN\tзначениеN\x0A Где: \x0A - разделитель записей (код ASCII: 0Ah) \t - разделитель ключа и значения (табуляция, код ASCII: 09h) Символы разделителей гарантированно не могут встречаться в ключах или значениях.</li>
  <li>Записи упорядочены по ключу в лексикографическом порядке с учетом регистра.</li>
  <li>Все ключи гарантированно уникальные.</li>
</ol>
