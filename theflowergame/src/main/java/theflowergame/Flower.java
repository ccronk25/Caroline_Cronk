package theflowergame;

import java.awt.Color;
import java.awt.Dimension;
import java.awt.Insets;
import java.awt.event.ActionListener;
import javax.swing.JButton;

/**
 * The units of the game represented by boxes; they must execute the rules.
 * @author ccronk
 */

public class Flower {
    
    private boolean isAlive; //current alive status
    private boolean shouldBeAlive; //alive status set by getNewStatus
    private final int row;
    private final int column;
    private final Garden garden;
    private JButton button; //each flower creates and remembers its own button
    
    private static final int[][] possibleNeighbors = {
        {-1,0},
        {-1,1},
        {-1,-1},
        {1,-1},
        {1,0},
        {1,1},
        {0,1},
        {0,-1}  
    }; //for locating possible flower neighbors
    
    public static final Color DEAD = new Color(40,90,0);
    public static final Color ALIVE = new Color(240,230,230);
    public static final int BUTTON_SIZE = 12; //size of flower button

    
    /**
     * Constructs a Flower and a button, connecting that flower to the button and the larger garden grid.
     * @param aliveStatus true alive, false if dead
     */
    public Flower(int flowerRow, int flowerColumn, Garden theGarden, boolean aliveStatus)
    {
        isAlive = aliveStatus;
        shouldBeAlive = false;
        row = flowerRow;
        column = flowerColumn;
        garden = theGarden;
        button = new JButton();
        button.setPreferredSize(new Dimension(BUTTON_SIZE,BUTTON_SIZE));
        button.setMargin(new Insets(0,0,0,0));
        setColor(aliveStatus);
        ActionListener listener = new FlowerListener(this);
        button.addActionListener(listener);
        
    }
    
    /**
     * Sets the flower's alive status (true = alive, false = dead) and color.
     */
    public void setStatus(boolean alive)
    {
        isAlive = alive;
        setColor(isAlive);
    }
    
    //Accessor
    public boolean isAlive()
    {
        return isAlive;
    }
    
    /**
     * Utilizes the array of possible neighbors to find adjacent flowers, check their
     * alive status, and count the number that return true. Allows for implementation of rules.
     * @return the number of living flowers in the 8 surrounding squares
     */
    public int getLivingNeighbors()
    {
        int livingNeighbors = 0;
        Flower[][] gardenFlowers = garden.getFlowerGrid(); //access the flower grid
        //go through possibleNeighbors
        for(int[] neighbor : possibleNeighbors)
        {
            int nRow = row + neighbor[0]; //location of object calling this method
            int nColumn = column + neighbor[1]; //plus or minus to get to the neighboring squares
            
            if(nRow >= 0 && nRow < Garden.ROWS && nColumn >= 0 && nColumn < Garden.COLUMNS) //check it isn't out of bounds
            { 
                Flower currentNeighbor = gardenFlowers[nRow][nColumn]; //get flower at target location
                //check if they're alive
                if(currentNeighbor.isAlive())
                {
                //if yes, increment counter
                    livingNeighbors++;
                }
            }
        }
        return livingNeighbors;
    }
   
    /**
     * Uses the count from getLivingNeighbors() to apply the rules of the game.
     * It's executed separately from updating the flower's status, setting the instance
     * variable "shouldBeAlive" and not "isAlive." This allows for accurate following the 
     * rules despite the flowers updating in a for loop and not simultaneously.
     */
    public void getNewStatus()
    {
        int livingNeighbors = getLivingNeighbors();
        
        //Rule One. A living flower with less than two living neighbors is cut off. It dies.
        //Rule Two. A living flower with two or three living neighbors is connected. It lives.
        //Rule Three. A living flower with more than three living neighbors is starved and overcrowded. It dies.
        //Rule Four. A dead flower with exactly three living neighbors is reborn. It springs back to life.
        
        //However, I don't need to program every rule exactly.
        if(livingNeighbors < 2 || livingNeighbors > 3)
        { //Both rules that kill a flower
            shouldBeAlive = false;
        }  
        else if(livingNeighbors == 3)
        { //only rule that changes a flower to alive
            shouldBeAlive = true;
        }
        else
        { //otherwise the flower should stay the same.
            shouldBeAlive = isAlive;
        }
    }
    
    /**
     * Updates the flower's status to match shouldBeAlive from getNewStatus.
     */
    public void updateStatus()
    {
        setStatus(shouldBeAlive); //sets the color then, too
    }
    
    //Accessor
    public int getRow() 
    {
        return row;
    }
    
    //Accessor
    public int getColumn() 
    {
        return column;
    }
    
    /**
     * sets the color of the flower's button according to whether it's alive.
     */
    public void setColor(boolean status)
    {
        if(status) //if true, alive
        {
            button.setBackground(ALIVE);
        }
        else //else (false), dead
        {
            button.setBackground(DEAD);
        }    
    }
    
    //Accessor
    public JButton getButton() 
    {
        return button;
    }
   
}
