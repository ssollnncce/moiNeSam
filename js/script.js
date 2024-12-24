    // Элементы
    const checkbox = document.getElementById('custom_type_check');
    const select = document.getElementById('cleaning_type');
    const customOption = Array.from(select.options).find(option => option.value === 'custom');
    const customTextContainer = document.getElementById('custom-type__text');

    // Функция настройки состояния списка
    function updateSelectState() {
        if (checkbox.checked) {
            // Если чекбокс активен
            if (!customOption.parentElement) {
                select.add(customOption); // Добавляем обратно, если удалено
            }
            select.value = 'custom'; // Устанавливаем значение "custom"
            Array.from(select.options).forEach(option => {
                if (option.value !== 'custom') {
                    option.style.display = 'none'; // Скрываем остальные
                }
            });
            customTextContainer.style.visibility = 'visible';
        } else {
            // Если чекбокс выключен
            Array.from(select.options).forEach(option => {
                option.style.display = ''; // Показать все опции
            });
            if (customOption.parentElement) {
                select.removeChild(customOption); // Удаляем опцию "custom"
            }
            select.selectedIndex = 0; // Возвращаем выбор к первой опции
            customTextContainer.style.visibility = 'hidden';
        }
    }

    // Запуск при загрузке страницы
    document.addEventListener('DOMContentLoaded', function () {
        updateSelectState(); // Устанавливаем начальное состояние
    });

    // Обработчик изменения чекбокса
    checkbox.addEventListener('change', function () {
        updateSelectState(); // Обновляем состояние при изменении
    });

// Функция для показа/скрытия причины отклонения
function toggleDeclinedReason(select) {
    const formId = select.closest('form').querySelector('[name="order_id"]').value;
    const reasonContainer = document.getElementById('declinedReasonContainer_' + formId);
    if (select.value === 'declined') {
        reasonContainer.style.display = 'block';
    } else {
        reasonContainer.style.display = 'none';
    }
}

// Инициализация при загрузке
document.addEventListener('DOMContentLoaded', () => {
    const selects = document.querySelectorAll('select[name="status"]');
    selects.forEach(select => toggleDeclinedReason(select));
});