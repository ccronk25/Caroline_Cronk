package checkers;

/**
 *
 * @author cecronk
 */
public class Piece {
    
    private boolean isRed;
    private boolean isKing;
    private Square currentSquare;
    private Board myBoard;
    private Runner gameRunner;
    
    private static final int[][] redMoves = { //default moves for red piece (towards right)
        {-1,1},
        {1,1}
    };
    private static final int[][] blackMoves = { //default moves for black piece (towards left)
        {-1,-1},
        {1,-1}
    };
    
    private static final int[][] kingMoves = {
        {-1,1},
        {1,1},
        {-1,-1},
        {1,-1}
    };
    
    public Piece(boolean red, Square location, Board board, Runner runner)
    {
        isKing = false;
        isRed = red;
        currentSquare = location;
        myBoard = board;
        gameRunner = runner;
    }
    
    public void selectPiece()
    {
        if(currentSquare.isSelected())
        {
            deselect();
        }
        else
        {    
            if(gameRunner.getSelectedPiece() == null) //if no other piece is selected
            { 
                gameRunner.setSelectedPiece(this);
                currentSquare.setSelection(true);
                showMoves();
            } 
        }
    }
    
    public void showMoves()
    {
        Square[][] squares = myBoard.getSquareArray();
        int[][] moves = getPossibleMoves();
        
        for(int[] currentMove : moves)
        {
            int nRow = currentSquare.getRow() + currentMove[0];
            int nColumn = currentSquare.getColumn() + currentMove[1];
            
            if(nRow >= 0 && nRow < Board.ROWS && nColumn >= 0 && nColumn < Board.ROWS) //check it isn't out of bounds
            {
                Square newSquare = squares[nRow][nColumn];
                //if the target jump space has a piece on it
                if(newSquare.isOccupied())
                {
                    //check if pieces are different colors
                    if(!newSquare.getPiece().isRed() == isRed)
                    {
                        //if yes, move target jump space one more in that direction (so it jumps over rather than on the piece)
                        nRow = nRow + currentMove[0];
                        nColumn = nColumn + currentMove[1];
                        
                        if(nRow >= 0 && nRow < Board.ROWS && nColumn >= 0 && nColumn < Board.ROWS) //check it isn't out of bounds
                        {
                            //if the target jump space also isn't occupied
                            if(!squares[nRow][nColumn].isOccupied())
                            {
                                Square jumpSquare = newSquare;
                                newSquare = squares[nRow][nColumn];
                                newSquare.setColor(Square.SELECTED_BLACK);
                                newSquare.addJumpSquare(jumpSquare);
                            }  
                        }
                    }
                }
                else
                {
                    newSquare.setColor(Square.SELECTED_BLACK);
                }
            }
        }
        //return jumpSquare;
    }
    
    /**
     * Resets color and variables when a piece is no longer selected.
     */
    public void deselect()
    {
        Square[][] squares = myBoard.getSquareArray();
        for(Square[] squareRow : squares)
         {
            for(Square thisSquare: squareRow)
            {
                if(!thisSquare.isRed())
                {
                    thisSquare.setColor(Square.EMPTY_BLACK);
                }
            }
        }
        currentSquare.setSelection(false);
        gameRunner.setSelectedPiece(null);
    }
    
    /**
     * Determines eligible moves for this piece.
     * @return array of possible moves (one direction only or both directions).
     */
    public int[][] getPossibleMoves()
    {
        if(isKing)
        {
            return kingMoves;
        }
        else if(isRed)
        {
            return redMoves;
        }
        else
        {
            return blackMoves;
        }
    }
    
    public void move(Square newSquare)
    {
        deselect();
        currentSquare.removePiece(this);
        newSquare.addPiece(this);
        currentSquare = newSquare;
        int endColumn = 0;
        if(isRed)
        {
            endColumn = 7;
        }
        if(currentSquare.getColumn() == endColumn)
        {
            isKing = true;
            currentSquare.setPieceAppearance();
        }
        gameRunner.swapTurn();
    }    
    
    public boolean isRed()
    {
        return isRed;
    }
     
    public boolean isKing()
    {
        return isKing;
    }
}
