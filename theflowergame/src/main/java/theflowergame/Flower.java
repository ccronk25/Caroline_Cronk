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
    
    private boolean isAlive; //current alive status. true = alive, false = dead
    private boolean nextStatus; //alive status for the next generation (set by getNewStatus)
    private final int row; //location in flowers array
    private final int column; //location in flowrs array
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
    
    public static final boolean ALIVE = true;
     public static final boolean DEAD = false;
    public static final Color DEAD_COLOR = new Color(40,90,0);
    public static final Color ALIVE_COLOR = new Color(240,230,230);
    public static final int BUTTON_SIZE = 12; //size of flower button

    
    /**
     * Constructs a Flower and a button, connecting that flower to the button and the larger garden grid.
     * @param aliveStatus true alive, false if dead
     */
    public Flower(int flowerRow, int flowerColumn, Garden theGarden, boolean aliveStatus){
        isAlive = aliveStatus;
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
    public void setStatus(boolean alive){
        isAlive = alive;
        setColor(isAlive);
    }
    
    //Accessor
    public boolean isAlive() {
        return isAlive;
    }
    
    /**
     * Utilizes the array of possible neighbors to find adjacent flowers, check their
     * alive status, and count the number that return true. Allows for implementation of rules.
     * @return the number of living flowers in the 8 surrounding squares
     */
    public int getLivingNeighbors(){
        int livingNeighbors = 0;
        Flower[][] gardenFlowers = garden.getFlowerGrid(); //access the flower grid
        
        //loop through 8 neighboring flowers
        for(int[] neighbor : possibleNeighbors){
            //use the array to add or subtract from the current flower to get the index of the neighbors
            int nRow = row + neighbor[0]; 
            int nColumn = column + neighbor[1]; 
            
            //if it isn't out of bounds
            if(nRow >= 0 && nRow < Garden.ROWS && nColumn >= 0 && nColumn < Garden.COLUMNS)  { 
                //get flower at target location and check if theyre alive
                Flower currentNeighbor = gardenFlowers[nRow][nColumn]; 
                if(currentNeighbor.isAlive()){
                    livingNeighbors++;
                }
            }
        }
        return livingNeighbors;
    }
   
    /**
     * Uses the count from getLivingNeighbors() to apply the rules of the game.
     * It's executed separately from updating the flower's status, setting the instance
     * variable "nextStatus" and not "isAlive." This allows for accurate following the 
     * rules despite the flowers updating in a for loop and not simultaneously.
     */
    public void getNewStatus(){
        int livingNeighbors = getLivingNeighbors();
        
        //Rule One. A living flower with two or three living neighbors is connected. It lives. (stays the same)
        
        //Rule Two. A living flower with less than two living neighbors is cut off. It dies.
        //Rule Three. A living flower with more than three living neighbors is starved and overcrowded. It dies.
        if(livingNeighbors < 2 || livingNeighbors > 3){ 
            nextStatus = DEAD;
        }  
        //Rule Four. A dead flower with exactly three living neighbors is reborn. It springs back to life.
        else if(livingNeighbors == 3){
            nextStatus = ALIVE;
        }
    }
    
    /**
     * Updates the flower's status to match nextStatus from getNewStatus.
     */
    public void updateStatus(){
        setStatus(nextStatus);
    }
    
    //Accessor
    public int getRow(){
        return row;
    }
    
    //Accessor
    public int getColumn(){
        return column;
    }
    
    /**
     * sets the color of the flower's button according to whether it's alive.
     */
    public void setColor(boolean status){
        if(status = ALIVE){
            button.setBackground(ALIVE_COLOR);
        }
        else {
            button.setBackground(DEAD_COLOR);
        }    
    }
    
    //Accessor
    public JButton getButton() 
    {
        return button;
    }
   
}
