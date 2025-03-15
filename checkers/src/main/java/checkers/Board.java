package checkers;

import javax.swing.JPanel;
import javax.swing.JButton;

/**
 *
 * @author cecronk
 */
public class Board {
    
    private JPanel myPanel;
    private Square[][] squares;
    private Runner gameRunner;

    public static final int ROWS = 8;
    
    public Board(Runner runner)
    {
        gameRunner = runner;
        myPanel = gameRunner.getPanel();
        
        squares = new Square[ROWS][ROWS];
        
        for(int ii = 0; ii<ROWS; ii++)
        {
            for(int jj = 0; jj<ROWS; jj++)
            {
                boolean isRed = true;
                
                if(ii%2 == 0)
                {
                    if(jj%2 == 0)
                    {
                        isRed = false;
                    } 
                }
                else
                {
                    if(jj%2 == 1)
                    {
                        isRed = false;
                    }
                }
                squares[ii][jj] = new Square(ii,jj,isRed,gameRunner);
                JButton currentButton = squares[ii][jj].getButton();
                myPanel.add(currentButton);
            }
        }
        
        initiatePieces();
    }
    
    public void initiatePieces()
    {
        for(int ii = 0; ii<ROWS; ii++)
        {
            for(int jj = 0; jj<ROWS; jj++)
            {
                if(!squares[ii][jj].isRed())
                {
                    if(jj <= 2)
                    {
                        Piece currentPiece = new Piece(true, squares[ii][jj],this,gameRunner);//red
                        squares[ii][jj].addPiece(currentPiece); 
                    }
                    else if (jj >= 5)
                    {
                        Piece currentPiece = new Piece(false, squares[ii][jj],this,gameRunner);//black
                        squares[ii][jj].addPiece(currentPiece);  
                    }      
                }
            }
        }
    }
    
    public Square[][] getSquareArray()
    {
        return squares;
    }
}
