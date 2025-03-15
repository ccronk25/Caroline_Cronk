package checkers;

import java.awt.Color;
import javax.swing.JButton;
import java.awt.Dimension;
import java.awt.Insets;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.ArrayList;
import javax.swing.ImageIcon;


/**
 *
 * @author cecronk
 */
public class Square {
    
    private int row;
    private int column;
    private JButton myButton;
    private boolean isRed;
    private boolean isOccupied;
    private boolean isSelected;
    private Piece currentPiece;
    private Runner gameRunner;
    
    private ArrayList<Square> jumpSquares;
    
    public static final int BUTTON_SIZE = 70;
    public static final Color EMPTY_BLACK = new Color(50,50,50);
    public static final Color SELECTED_BLACK = new Color(110,110,110);
    
    private static final ImageIcon blackCheckersPiece = new ImageIcon("C:/Users/cecro/pictures/Checkers/bCheckersPiece.png");
    private static final ImageIcon redCheckersPiece = new ImageIcon("C:/Users/cecro/pictures/Checkers/rCheckersPiece.png");
     private static final ImageIcon bKingCheckersPiece = new ImageIcon("C:/Users/cecro/pictures/Checkers/bkCheckersPiece.png");
    private static final ImageIcon rKingCheckersPiece = new ImageIcon("C:/Users/cecro/pictures/Checkers/rkCheckersPiece.png");
    
    public Square(int currentRow,int currentColumn,boolean red,Runner runner)
    {
        gameRunner = runner;
        row = currentRow;
        column = currentColumn;
        isRed = red;
        isOccupied = false;
        isSelected = false;
        jumpSquares = new ArrayList<Square>();
        myButton = new JButton();
        myButton.setPreferredSize(new Dimension(BUTTON_SIZE,BUTTON_SIZE));
        myButton.setMargin(new Insets(0,0,0,0));
        myButton.addActionListener(
        new ActionListener()
        {
            @Override
            public void actionPerformed(ActionEvent e)
            {
                if(isOccupied && currentPiece != null)
                { 
                    if(gameRunner.isRedTurn() == currentPiece.isRed())
                    {
                        currentPiece.selectPiece();
                    }
                }
                else if(getColor() == SELECTED_BLACK)
                {
                    move();
                }
            }
        }
        );
        
        if(red == true)
        {
            myButton.setBackground(Color.RED);
        }
        else
        {
            myButton.setBackground(EMPTY_BLACK);
        }
        
    }
    
    public void move()
    {
        gameRunner.getSelectedPiece().move(this);
        if(jumpSquares.size() > 0)
        {
            for(Square jumpSquare : jumpSquares)
            {
                if(jumpSquare.getPiece() != null)
                {
                    gameRunner.capture(jumpSquare.getPiece().isRed());
                    jumpSquare.removePiece(jumpSquare.getPiece());
                }    
            }
            jumpSquares.clear();
        }
    }
    
    public JButton getButton()
    {
        return myButton;
    }
    
    public void addPiece(Piece newPiece)
    {
        isOccupied = true;
        currentPiece = newPiece;
        setPieceAppearance();
    }
    
    public void removePiece(Piece newPiece)
    {
        isOccupied = false;
        myButton.setIcon(null);
        currentPiece = null;
    }
    
    public void addJumpSquare(Square newSquare)
    {
        jumpSquares.add(newSquare);
    }
    
    public void setSelection(boolean selected)
    {
        isSelected = selected;
        if(selected)
        {
            setColor(SELECTED_BLACK);
        }
        else
        {
            setColor(EMPTY_BLACK);
        }
    }
    
    public void setPieceAppearance()
    {
        if(currentPiece.isRed())
        {
            if(currentPiece.isKing())
            {
                myButton.setIcon(rKingCheckersPiece);

            }
            else
            {
                myButton.setIcon(redCheckersPiece);
            } 
        }
        else
        {
            if(currentPiece.isKing())
            {
                myButton.setIcon(bKingCheckersPiece);
            }
            else
            {
                myButton.setIcon(blackCheckersPiece);
            } 
        }
    }
    
    public void setColor(Color newColor)
    {
        myButton.setBackground(newColor);
    }
     
    public Piece getPiece()
    {
        return currentPiece;
    }
    
    public boolean isRed()
    {
        return isRed;
    }
    
    public boolean isSelected()
    {
        return isSelected;
    }
    
    public boolean isOccupied()
    {
        return isOccupied;
    }
    
    public Color getColor()
    {
        return myButton.getBackground();
    }

    public int getRow()
    {
        return row;
    }
    
    public int getColumn()
    {
        return column;
    }

}
