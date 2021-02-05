const x_class= 'x'
const circle_class = 'circle'
const kombinasi_menang = [
  [0, 1, 2],
  [3, 4, 5],
  [6, 7, 8],
  [0, 3, 6],
  [1, 4, 7],
  [2, 5, 8],
  [0, 4, 8],
  [2, 4, 6]
]
const cellElements = document.querySelectorAll('[data-cell]')
const board = document.getElementById('board')
const pesanMenangElement = document.getElementById('pesanMenang')
const restartButton = document.getElementById('restartButton')
const pesanMenangTextElement = document.querySelector('[data-pesan-menang-text]')
let circleTurn

mulaiMain()

restartButton.addEventListener('click', mulaiMain)

function mulaiMain() {
  circleTurn = false
  cellElements.forEach(cell => {
    cell.classList.remove(x_class)
    cell.classList.remove(circle_class)
    cell.removeEventListener('click', handleClick)
    cell.addEventListener('click', handleClick, { once: true })
  })
  setBoardHoverClass()
  pesanMenangElement.classList.remove('show')
}

function handleClick(e) {
  const cell = e.target
  const currentClass = circleTurn ? circle_class : x_class
  placeMark(cell, currentClass)
  if (checkPemenang(currentClass)) {
    gameSelesai(false)
  } else if (isDraw()) {
    gameSelesai(true)
  } else {
    swapTurns()
    setBoardHoverClass()
  }
}

function gameSelesai(draw) {
  if (draw) {
    pesanMenangTextElement.innerText = 'Permainan Seri!'
  } else {
    pesanMenangTextElement.innerText = `${circleTurn ? "O's" : "X's"} Menang!`
  }
  pesanMenangElement.classList.add('show')
}

function isDraw() {
  return [...cellElements].every(cell => {
    return cell.classList.contains(x_class) || 
    cell.classList.contains(circle_class)
  })
}

function placeMark(cell, currentClass) {
  cell.classList.add(currentClass)
}

function swapTurns() {
  circleTurn = !circleTurn
}

function setBoardHoverClass() {
  board.classList.remove(x_class)
  board.classList.remove(circle_class)
  if (circleTurn) {
    board.classList.add(circle_class)
  } else {
    board.classList.add(x_class)
  }
}

function checkPemenang(currentClass) {
  return kombinasi_menang.some(combination => {
    return combination.every(index => {
      return cellElements[index].classList.contains(currentClass)
    })
  })
}