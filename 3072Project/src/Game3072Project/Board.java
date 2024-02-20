package Game3072Project;

import javax.swing.JButton;

/**
 * A class that keeps track of the movement of the numbers on the board
 */
public class Board {
//---------------------------------------------
//                 PROPERTIES    
//---------------------------------------------
    //the array of integers, which holds the multiples of 3 on the gameboard
    private int[][] numbers;
    public int[][] getNumberArray(){ return numbers; }
    public void setNumberArray(int[][] numberArray){ numbers = numberArray; }
    
    //the array of JButtons for visual display of numbers array
    private JButton[][] buttons;
    public JButton[][] getButtonArray(){ return buttons; }
    public void setButtonArray(JButton[][] buttonArray){ buttons = buttonArray; }
    
    private int score;
    public int getScore(){ return score; }
    public void setScore(int newScore){ score = newScore; }
    
    private GamePages gamePage;
    public GamePages getGamePage(){ return gamePage; }
    public void setGamePage(GamePages game){ gamePage = game; }
    
//Static Variables
    //max and min for rows and columns on arrays
    public static final int MIN_SIZE = 0;
    public static final int MAX_SIZE = 4;
    
    //-1, 0, or 1, to be added to the current index to find what spot it should move to
    public static final int[] UP_MOVES = {-1,0};
    public static final int[] RIGHT_MOVES = {0,1};
    public static final int[] DOWN_MOVES = {1,0};
    public static final int[] LEFT_MOVES = {0,-1};
    
    //for keeping the direction codes cohesive and streamlined
    public static final int UP = 0;
    public static final int RIGHT = 1;
    public static final int DOWN = 2;
    public static final int LEFT = 3;
    
//---------------------------------------------
//                CONSTRUCTORS    
//---------------------------------------------
    //default constructor
    public Board(){
        setNumberArray(new int[MAX_SIZE][MAX_SIZE]);
        setButtonArray(new JButton[MAX_SIZE][MAX_SIZE]);
    }
    
    //passes in the array of JButtons from main, makes a new int array
    public Board(JButton[][] buttonArray){
        setNumberArray(new int[MAX_SIZE][MAX_SIZE]);
        setButtonArray(buttonArray);
    }
    
    //passes in the array of ints from main, makes an empty array of JButtons
    public Board(int[][] numberArray){
        setNumberArray(numberArray);
        setButtonArray(new JButton[MAX_SIZE][MAX_SIZE]);      
    }
    
    //full constructor
    public Board(int[][] numberArray, JButton[][] buttonArray){
        setNumberArray(numberArray);
        setButtonArray(buttonArray);     
    }

//---------------------------------------------
//                  METHODS    
//---------------------------------------------   
    //moves the entire board in specified direction
    public void move(int direction){
        //the for loop must work from the direction the sqaures are traveling 
        //- e.g. DOWN uses bottom to top rather than top to bottom - otherwise they will
        //be blocked by squares that haven't moved yet.
        switch(direction){
            //up goes top to bottom, left to right
            case UP: 
                for(int ii = 0; ii<MAX_SIZE; ii++){ 
                    for(int jj = 0; jj<MAX_SIZE; jj++){
                        if(ii!=MIN_SIZE){
                            moveInt(direction, ii, jj);
                        }
                    }
                }
                break;
            //right goes top to bottom, right to left 
            case RIGHT: 
                for(int ii = 0; ii<MAX_SIZE; ii++){
                    for(int jj = MAX_SIZE-1; jj>=MIN_SIZE; jj--){
                        moveInt(direction, ii, jj);
                    }
                }
                break;
            //down goes bottom to top, left to right   
            case DOWN: 
                for(int ii = MAX_SIZE-1; ii>=MIN_SIZE; ii--){
                    for(int jj = 0; jj<MAX_SIZE; jj++){
                        moveInt(direction, ii, jj);
                    }
                }
                break;
                
            case LEFT: //left goes top to bottom, left to right
                for(int ii = 0; ii<MAX_SIZE; ii++){
                    for(int jj = 0; jj<MAX_SIZE; jj++){
                        moveInt(direction, ii, jj);
                    }
                }
                break;
                
            default:
                break;
        }
        //Game rules: a new tile is generated after each move.
        generateTile(1);
    }    
               
    /**
     * Method to move an individual number. This method recursively calls itself until
     * the current number square hits an edge or another number square.
     * @param direction up, right, down, or left, represented by static variables
     * @param startingRow current row index
     * @param startingCol current col index
     */
    public void moveInt(int direction, int startingRow, int startingCol){
        int[] moves = getMoves(direction);
        
        int row = startingRow + moves[0];
        int col = startingCol + moves[1];
        
        if(row >= MIN_SIZE && row < MAX_SIZE && col >= MIN_SIZE && col < MAX_SIZE){
            
            int adj = findAdjacent(direction, startingRow, startingCol);

            if(adj == numbers[startingRow][startingCol] && adj != 0){ //if they're equal
                combine(direction,adj,startingRow,startingCol);
            }
            else if(adj == 0){
                adj = numbers[startingRow][startingCol];
                numbers[startingRow][startingCol] = 0;
                numbers[startingRow + moves[0]][startingCol + moves[1]] = adj;
                moveInt(direction, startingRow + moves[0], startingCol + moves[1]);
            }
            updateColor(startingRow,startingCol);
            updateColor(row,col);
        }    
    }
            
    /**
     * Find a number that the number at the index is going to run into
     * @return 0 if empty, 3-3072 if occupied, -1 if the edge of the board.
     */
    public int findAdjacent(int direction, int index1, int index2){
        //set adjacent to out of bounds (-1)
        int adjacent = -1; 
        
        //figure out which direction to search for neighbor in
        int[] moves = getMoves(direction);
        
        //find the row and column indexes for new location
        int row = index1 + moves[0];
        int col = index2 + moves[1];
        
        //get the integer value from that location and return it
        if(row >= MIN_SIZE && row < MAX_SIZE && col >= MIN_SIZE && col < MAX_SIZE){
            adjacent = numbers[row][col]; 
        }
        return adjacent;
    }
    
    /**
     * Combines two equal number squares
     * @param value the number in both squares
     */
    public void combine(int direction, int value, int index1,int index2) 
    {
        //combine the values
        int sum = 2*value;
        
        //figure out final destination of combined square
        int[] moves = getMoves(direction);
        
        //find the row and column indexes for new location
        int row = index1 + moves[0];
        int col = index2 + moves[1];
        
        //set new square value and old square to empty
        numbers[row][col] = sum;
        numbers[index1][index2] = 0;
        
        //increase score
        score = score + sum;
        gamePage.updateScore(score);

   } 
    
    /**
     * Finds which of the MOVES arrays to use in movement calculations.
     */
    public int[] getMoves(int direction){
        int[] moves = new int[2];

        switch (direction) {
            case UP:
                moves = UP_MOVES;
                break;
            case RIGHT:
                moves = RIGHT_MOVES;
                break;
            case DOWN:
                moves = DOWN_MOVES;
                break;
            case LEFT:
                moves = LEFT_MOVES;
                break;
            default:
                break;
        }
        return moves;
    }
    
    /**
     * Creates new number squares in random empty spaces
     * @param numberOfTiles How many squares to generate
     */
    public void generateTile(int numberOfTiles){  
        for(int count = 0; count<numberOfTiles; count++){
            //randomly choose one of valid starting tile numbers
                double threeOrSix = Math.random();
                if(threeOrSix>0.5){
                    threeOrSix = 3;
                }
                else{
                    threeOrSix = 6;
                }
            
//as long as there's space on the board, pick a random open spot
            if(countOpenSpots()>0){
                
                while(true){
                    //select random spots
                    int row = (int)(Math.random()*4);
                    int col = (int)(Math.random()*4);               

                    if(numbers[row][col]==0){
                        numbers[row][col]=(int)threeOrSix;
                        updateColor(row,col);

                        //exit the while loop once tile is generated
                        break;
                    }
                }
            }
            else{
                gamePage.gameOver();
            }
        }
    }
    
    //Counts the number of empty spaces on the board
    public int countOpenSpots(){
        int count = 0; 
        
        //checks each index of the array of numbers for empty spots (0)
        for(int ii = 0; ii<MAX_SIZE; ii++){
            for(int jj = 0; jj<MAX_SIZE; jj++){
                if(numbers[ii][jj]==0){
                    count++;
                }
            }
        }
        return count; 
    } 
    
    //changes the color of a button on the board, the darker the higher the value
    //Contains the win condition
    public void updateColor(int ii, int jj){
        int value = numbers[ii][jj];
        JButton button = buttons[ii][jj];
        
        button.setText("" + value);
        
        switch(value){
            case 3:
                button.setBackground(GamePages.Color3);
                break;
            case 6:
                button.setBackground(GamePages.Color6);
                break;
            case 12:
                button.setBackground(GamePages.Color12);
                break;
            case 24:
                button.setBackground(GamePages.Color24);
                break;
            case 48:
                button.setBackground(GamePages.Color48);
                break;
            case 96:
                button.setBackground(GamePages.Color96);
                break;
            case 192:
                button.setBackground(GamePages.Color192);
                break;
            case 384:
                button.setBackground(GamePages.Color384);
                break;
            case 768:
                button.setBackground(GamePages.Color768);
                break;
            case 1536:
                button.setBackground(GamePages.Color1536);
                break;
            case 3072:
                button.setBackground(GamePages.Color3072);
                
                //If a 3072 tile is generated, win
                gamePage.win();
                break;
            //0 or otherwise
            default: 
                button.setBackground(GamePages.normalBackground);
                button.setText("");
                break;  
        }
        
    }
}
