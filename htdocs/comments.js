// JavaScript для работы с комментариями через API
class CommentsManager {
  constructor(apiUrl = "/api/comments.php") {
    this.apiUrl = apiUrl
  }

  // Загрузить комментарии для обновления
  async loadComments(updateId) {
    try {
      const response = await fetch(`${this.apiUrl}?update_id=${updateId}`)
      const data = await response.json()

      if (data.success) {
        this.displayComments(updateId, data.comments, data.count)
      } else {
        console.error("Ошибка загрузки комментариев:", data.error)
      }
    } catch (error) {
      console.error("Ошибка при загрузке комментариев:", error)
    }
  }

  // Отобразить комментарии
  displayComments(updateId, comments, count) {
    const updateNumber = updateId.replace("update", "")
    const commentsListId = `commentsList${updateNumber}`
    const commentsList = document.getElementById(commentsListId)

    if (!commentsList) return

    // Обновляем заголовок
    const commentsHeader = commentsList.closest(".comments-section").querySelector("h3")
    commentsHeader.textContent = `Комментарии (${count})`

    // Очищаем список
    commentsList.innerHTML = ""

    if (comments.length === 0) {
      commentsList.innerHTML = '<div class="no-comments">Пока нет комментариев. Будьте первым!</div>'
      return
    }

    // Добавляем комментарии
    comments.forEach((comment) => {
      const commentHTML = this.createCommentHTML(comment)
      commentsList.insertAdjacentHTML("beforeend", commentHTML)
    })
  }

  // Создать HTML для комментария
  createCommentHTML(comment) {
    return `
            <div class="comment" data-comment-id="${comment.id}">
                <div class="comment-header">
                    <span class="comment-author">${this.escapeHTML(comment.display_name || comment.author_name)}</span>
                    <span class="comment-date">${comment.formatted_date}</span>
                </div>
                <div class="comment-content">
                    <p>${this.escapeHTML(comment.content).replace(/\n/g, "<br>")}</p>
                </div>
                <div class="comment-actions">
                    <span class="comment-action" onclick="commentsManager.replyToComment(${comment.id})">Ответить</span>
                    <span class="comment-action like-btn" onclick="commentsManager.likeComment(${comment.id}, this)">
                        Лайк (${comment.likes_count || 0})
                    </span>
                </div>
            </div>
        `
  }

  // Добавить новый комментарий
  async addComment(updateId) {
    const updateNumber = updateId.replace("update", "")
    const textareaId = `commentText${updateNumber}`
    const nameId = `commentName${updateNumber}`
    const emailId = `commentEmail${updateNumber}`

    const content = document.getElementById(textareaId).value.trim()
    const authorName = document.getElementById(nameId).value.trim()
    const authorEmail = document.getElementById(emailId).value.trim()

    if (!content || !authorName) {
      alert("Пожалуйста, заполните текст комментария и ваше имя")
      return
    }

    const commentData = {
      update_id: Number.parseInt(updateNumber),
      content: content,
      author_name: authorName,
      author_email: authorEmail,
    }

    try {
      const response = await fetch(this.apiUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(commentData),
      })

      const data = await response.json()

      if (data.success) {
        // Очищаем форму
        document.getElementById(textareaId).value = ""
        document.getElementById(nameId).value = ""
        document.getElementById(emailId).value = ""

        // Перезагружаем комментарии
        this.loadComments(updateId)

        alert("Ваш комментарий успешно добавлен!")
      } else {
        alert("Ошибка: " + data.error)
      }
    } catch (error) {
      console.error("Ошибка при добавлении комментария:", error)
      alert("Произошла ошибка при отправке комментария")
    }
  }

  // Лайкнуть комментарий
  async likeComment(commentId, buttonElement) {
    try {
      const response = await fetch(this.apiUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          action: "like",
          comment_id: commentId,
        }),
      })

      const data = await response.json()

      if (data.success) {
        buttonElement.textContent = `Лайк (${data.likes_count})`
        buttonElement.style.color = "#ff6f61"
        buttonElement.onclick = null // Отключаем повторные клики
      } else {
        alert(data.error)
      }
    } catch (error) {
      console.error("Ошибка при добавлении лайка:", error)
    }
  }

  // Ответить на комментарий (заглушка)
  replyToComment(commentId) {
    alert(`Функция ответа на комментарий #${commentId} будет добавлена в следующем обновлении`)
  }

  // Экранирование HTML
  escapeHTML(text) {
    const div = document.createElement("div")
    div.textContent = text
    return div.innerHTML
  }
}

// Создаем глобальный экземпляр менеджера комментариев
const commentsManager = new CommentsManager()

// Функция для совместимости с существующим кодом
function addComment(updateId) {
  commentsManager.addComment(updateId)
}

// Загружаем комментарии при показе деталей обновления
function showUpdateDetail(id) {
  // Существующий код показа деталей
  document.querySelectorAll(".update-detail").forEach((el) => {
    el.classList.remove("active")
  })

  document.getElementById(id).classList.add("active")
  document.getElementById(id).scrollIntoView({ behavior: "smooth" })

  // Загружаем комментарии
  commentsManager.loadComments(id)
}
