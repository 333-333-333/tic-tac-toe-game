class Cell {
    
    
    constructor(element, clickHandler) {
        this.element = element;
        this.element.addEventListener('click', clickHandler);
        this.symbol = null;
    }

    setSymbol(symbol) {
        this.symbol = symbol;
        this.element.textContent = symbol;
    }


}


class Board {
    

    constructor(elements, cellHandler) {
        this.cells = elements.map((cellElement, index) => {
            return new Cell(cellElement, () => cellHandler(index));
        });
    }


}


class Game {
    
    
    constructor() {
        const cellArray = Array.from(document.querySelectorAll('.cell'));
        this.board = new Board(cellArray, (index) => this.cellClicked(index));
        this.status = document.querySelector('#status');
        this.restart = document.querySelector('#restart');
        this.restart.addEventListener('click', () => this.startClicked());
    }

    getGameState() { 
        const board = this.board.cells.map((cell) => cell.symbol);
        const currentPlayer = this.status.textContent.includes('X') ? 'X' : 'O';
        const winner = this.status.textContent.includes('Winner') ? currentPlayer : null;
        const status = "playing"

        if (this.status.textContent.includes('Tie')) {
            status = "tie"
        }

        if (this.status.textContent.includes('Winner')) {
            status = "win"
        }

        return {
            board,
            currentPlayer,
            winner,
            status,
        };
    }


    updateUI(gameState) {
        gameState.board.forEach((symbol, index) => {
            if (symbol != ' ') {
                this.board.cells[index].setSymbol(symbol);
            } else {
                this.board.cells[index].setSymbol(' ');
            }
        });

        if (gameState.status == "playing") {
            this.status.textContent = `Player ${gameState.currentPlayer}'s turn`;
        }

        if (gameState.status == "tie") {
            this.status.textContent = `Tie`;
        }

        if (gameState.status == "won") {
            this.status.textContent = `Winner: ${gameState.winner}`;
        }


    }


    async cellClicked(index) {
        const response = await fetch(`${SERVER_URL}/api/updateCell/${index}`, {
            method: 'POST',
            body: JSON.stringify(this.getGameState()),
        });
       
        const gameState = await response.json();
        
        console.log(gameState);
        this.updateUI(gameState);
    }

    async startClicked() {
        const response = await fetch(`${SERVER_URL}/api/start`, {
            method: 'GET',
        });
        
        const gameState = await response.json();
        
        this.updateUI(gameState);
    }


}


/**
 * TODO: Put the SERVER_URL value in a '.env'.
 */

const SERVER_URL = 'http://127.0.0.1:8000'

window.addEventListener('load', async () => {
    const game = new Game();
    game.startClicked();
});